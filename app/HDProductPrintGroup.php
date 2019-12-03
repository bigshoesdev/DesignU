<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductPrintGroup extends Model
{
    protected $table = 'hd_product_print_group';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
