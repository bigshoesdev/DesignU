<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyFile extends Model
{
    protected $table = 'my_file';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
