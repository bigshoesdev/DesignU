<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrderExchangeReturn extends Model
{
    protected $table = 'product_order_exchange_return';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
