<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrderDelivery extends Model
{
    protected $table = 'product_order_delivery';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
