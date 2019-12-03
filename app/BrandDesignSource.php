<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandDesignSource extends Model
{
    protected $table = 'brand_design_source';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
