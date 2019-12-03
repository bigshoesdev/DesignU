<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandSNS extends Model
{
    protected $table = 'brand_sns';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
