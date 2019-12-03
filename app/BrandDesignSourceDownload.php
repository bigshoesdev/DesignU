<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandDesignSourceDownload extends Model
{
    protected $table = 'brand_design_source_download';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
