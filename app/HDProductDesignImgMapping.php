<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductDesignImgMapping extends Model
{
    protected $table = 'hd_product_design_img_mapping';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
