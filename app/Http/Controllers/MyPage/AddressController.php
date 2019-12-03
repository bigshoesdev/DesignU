<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;
use App\UserAddress;

class AddressController extends Controller
{
    public function addAddress(Request $req)
    {
        $user = Sentinel::getUser();

        $address = new UserAddress($req->all());
        $address->user_id = $user->id;
        $address->selected = 0;
        $address->save();

        UserAddress::makeFirstAddressSelected($user);

        $data = array();
        $data['success'] = true;
        $data['addressList'] = UserAddress::where('user_id', $user->id)->get();

        return json_encode($data);
    }

    public function listAddress() {
        $user = Sentinel::getUser();

        $data = array();
        $data['success'] = true;
        $data['addressList'] = UserAddress::where('user_id', $user->id)->get();

        return json_encode($data);
    }

    public function applyAddress(Request $req) {
        $user = Sentinel::getUser();

        $address = UserAddress::getSelectedAddress($user);
        $address->selected = 0;
        $address->save();


        $address = UserAddress::find($req->get('id'));
        $address->selected = 1;
        $address->save();

        $data = array();

        $data['success'] = true;
        $data['addressList'] = UserAddress::where('user_id', $user->id)->get();

        return json_encode($data);
    }

    public function deleteAddress(Request $req) {
        $user = Sentinel::getUser();

        $address = UserAddress::find($req->get('id'));
        $address->delete();

        UserAddress::makeFirstAddressSelected($user);

        $data = array();

        $data['success'] = true;
        $data['addressList'] = UserAddress::where('user_id', $user->id)->get();

        return json_encode($data);
    }
}