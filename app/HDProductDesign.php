<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductDesign extends Model
{
    protected $table = 'hd_product_design';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function getImages()
    {
        return $this->hasMany(HDProductDesignImg::class, 'design_id');
    }
}
