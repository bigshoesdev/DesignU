<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductSize extends Model
{
    protected $table = 'hd_product_size';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
