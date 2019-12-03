<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductPatternImg extends Model
{
    protected $table = 'hd_product_pattern_img';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
