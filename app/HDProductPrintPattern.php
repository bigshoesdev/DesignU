<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductPrintPattern extends Model
{
    protected $table = 'hd_product_print_pattern';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
