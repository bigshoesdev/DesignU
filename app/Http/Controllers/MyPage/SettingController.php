<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use App\Http\Requests\MyPageSettingRequest;
use Illuminate\Http\Request;
use Sentinel;

class SettingController extends Controller
{
    public function saveSetting(MyPageSettingRequest $req)
    {
        $user = Sentinel::getUser();

        if ($req->has('name'))
            $user->name = $req->get('name');

        if ($req->has('email'))
            $user->email = $req->get('email');

        if ($req->has('hp'))
            $user->hp = $req->get('hp');

        if ($req->has('msn'))
            $user->msn = $req->get('msn');

        $user->save();

        $data['user'] = $user;

        return redirect()->route('mypage.setting')->with('success', 'Your Setting is Succesfully Saved.');;
    }

    public function uploadPic(Request $req)
    {

        if ($req->hasFile('img')) {
            $file = $req->file('img');
            $user = Sentinel::getUser();

            $oldImg = $user->pic;

            $folderPath = 'uploads/logo/';
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            $file->move($folderPath, $fileName);

            $user->pic = $folderPath. $fileName;
            $user->save();

            unlink($oldImg);

            $data = array();
            $data['pic'] = $user->pic;
            $data['success'] = true;

            return json_encode($data);
        }
    }
}