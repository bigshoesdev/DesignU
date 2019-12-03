<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductImg extends Model
{
    protected $table = 'hd_product_img';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
