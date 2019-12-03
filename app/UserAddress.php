<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_address';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public static function makeFirstAddressSelected($user)
    {
        $address = UserAddress::where(['user_id' => $user->id, 'selected' => 1])->first();

        if (empty($address)) {
            $address = UserAddress::where(['user_id' => $user->id, 'selected' => 0])->first();

            if (empty($address)) {
                return false;
            } else {
                $address->selected = 1;
                $address->save();
                return true;
            }
        } else
            return false;
    }

    public static function getSelectedAddress($user) {
        $address = UserAddress::where(['user_id' => $user->id, 'selected' => 1])->first();

        if(empty($address))
            return null;
        else
            return $address;
    }
}
