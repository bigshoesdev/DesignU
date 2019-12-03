<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductCustomDrawOrderDelivery extends Model
{
    protected $table = 'hd_product_customdraw_order_delivery';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
