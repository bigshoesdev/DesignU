<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductStyle extends Model
{
    protected $table = 'product_style';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
