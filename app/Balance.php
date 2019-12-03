<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balance';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
