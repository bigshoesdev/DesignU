<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductPatternMapping extends Model
{
    protected $table = 'hd_product_pattern_mapping';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function getMappedDesignImages() {
        return $this->hasMany(HDProductDesignImgMapping::class, 'pattern_mapping_id');
    }
}
