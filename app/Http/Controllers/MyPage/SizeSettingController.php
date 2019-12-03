<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MySizeSetting;
use Sentinel;

class SizeSettingController extends Controller
{
    public function getSizeSettingInfo()
    {
        $sizeSettings = Sentinel::getUser()->getSizes()->get();

        $data = array();
        $data['sizeSettings'] = $sizeSettings;

        return json_encode($data);
    }

    public function saveSizeSetting(Request $req)
    {
        $sizeSetting = new MySizeSetting();

        $sizeSetting->name = $req->get('name');
        $sizeSetting->gender = $req->get('gender');
        $sizeSetting->user_id = Sentinel::getUser()->id;
        $sizeSetting->size = json_encode($req->get('size'));
        $sizeSetting->status = 1;
        $sizeSetting->selected = 0;

        $data = array();

        if (empty(MySizeSetting::where('name', $sizeSetting->name)->first())) {
            $sizeSetting->save();
            $data['success'] = true;
            $data['sizeSettings'] = Sentinel::getUser()->getSizes()->get();
        } else {
            $data["sucess"] = false;
            $data["error"] = "There is a size box item with the same name";
        }

        return json_encode($data);
    }

    public function deleteSizeSetting(Request $req) {
        $size = MySizeSetting::find($req->get('id'));
        $size->status = 0;
        $size->save();

        $data['success'] = true;
        $data['sizeSettings'] = Sentinel::getUser()->getSizes()->get();

        return json_encode($data);
    }

    public function applySizeSetting(Request $req) {
        $sizeSetting = MySizeSetting::where(['user_id' => Sentinel::getUser()->id, 'selected' => 1])->first();

        if(!empty($sizeSetting)) {
            $sizeSetting->selected = 0;
            $sizeSetting->save();
        }
        $sizeSetting = MySizeSetting::find($req->get('id'));

        $sizeSetting->selected = 1;
        $sizeSetting->save();

        $data['success'] = true;
        $data['sizeSettings'] = Sentinel::getUser()->getSizes()->get();

        return json_encode($data);
    }
}