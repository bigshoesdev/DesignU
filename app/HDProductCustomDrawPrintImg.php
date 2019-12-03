<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductCustomDrawPrintImg extends Model
{
    protected $table = 'hd_product_customdraw_print_img';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
