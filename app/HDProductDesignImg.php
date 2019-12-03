<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductDesignImg extends Model
{
    protected $table = 'hd_product_design_img';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
