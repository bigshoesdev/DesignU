<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function getDesignSources()
    {
        return $this->hasMany(BrandDesignSource::class, 'brand_id');
    }

    public function getBrandSNSs()
    {
        return $this->hasMany(BrandSNS::class, 'brand_id');
    }
}
