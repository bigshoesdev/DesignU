<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductPrint extends Model
{
    protected $table = 'hd_product_print';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function getPrintPatterns()
    {
        return $this->hasMany(HDProductPrintPattern::class, 'print_id');
    }

    public function getPrintGroups()
    {
        return $this->hasMany(HDProductPrintGroup::class, 'print_id');
    }
}
