<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use App\Social;
use Auth;
use Sentinel;
use Redirect;

class SocialController extends Controller
{

    public function getSocialRedirect($provider)
    {

        $providerKey = Config::get('services.' . $provider);

        if (empty($providerKey)) {

            return view('errors.error')
                ->with('error', 'There is no provider for ' . $provider);
        }

        return Socialite::driver($provider)->redirect();

    }

    public function getSocialHandle($provider)
    {
        if (Input::get('denied') != '' || Input::get('error') != '' ) {

            return Redirect::route('auth.login')
                ->with('error', 'Your Social Account is denied or has been blocked.');
        }


        $socialUserObject = Socialite::driver($provider)->user();

        $socialUser = null;

        // Check if email is already registered
        $userCheck = User::where('email', '=', $socialUserObject->email)->first();

        $email = $socialUserObject->email;

        if (!$socialUserObject->email) {
            $email = 'missing' . str_random(10);
        }

        if (empty($userCheck)) {

            $social = Social::where('social_id', '=', $socialUserObject->id)
                ->where('provider', '=', $provider)
                ->first();

            if (empty($social)) {
                $username = $socialUserObject->nickname;
                if ($username == null)
                    $username = $socialUserObject->name;

                $userData = array();
                $userData['name'] = $username;
                $userData['email'] = $email;
                $userData['password'] = bcrypt(str_random(40));
                $userData['token'] = str_random(64);
                $userData['is_factory'] = 0; // Client Mode
                $user = Sentinel::register($userData, true);

                $role = Sentinel::findRoleByName('User');
                $role->users()->attach($user);

                $socialData = new Social;
                $socialData->social_id = $socialUserObject->id;
                $socialData->provider = $provider;
                $user->social()->save($socialData);

                if (!empty($socialUserObject->avatar)) {
                    $image_name = time() . '.png';
                    $img_path = public_path('uploads/logo/' . $image_name);
                    if (file_put_contents($img_path, file_get_contents($socialUserObject->avatar))) {
                        $user->pic = 'uploads/logo/' . $image_name;
                    }
                }

                $user->save();
                $socialUser = $user;

            } else {
                $socialUser = $social->user;
            }

            Sentinel::login($socialUser, false);
            return Redirect::route('home');
        }

        $socialUser = $userCheck;

        Sentinel::login($socialUser, true);

        return Redirect::route('home');

    }
}
