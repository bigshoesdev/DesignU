<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductCustomDrawOrderExchangeReturn extends Model
{
    protected $table = 'hd_product_customdraw_order_exchange_return';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
