<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MySizeSetting extends Model
{
    protected $table = 'my_size_setting';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
