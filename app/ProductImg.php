<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    protected $table = 'product_img';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
