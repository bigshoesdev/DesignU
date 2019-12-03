<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductPattern extends Model
{
    protected $table = 'hd_product_pattern';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function getImages()
    {
        return $this->hasMany(HDProductPatternImg::class, 'pattern_id');
    }

    public function deleteImages() {
        $this->getImages()->delete();
    }

    public function getMapping() {
        return $this->hasOne(HDProductPatternMapping::class, 'pattern_id');
    }
}
