<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductCustomDrawColor extends Model
{
    protected $table = 'hd_product_customdraw_color';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
