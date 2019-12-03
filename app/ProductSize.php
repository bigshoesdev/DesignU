<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $table = 'product_size';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
