<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductCustomDrawFigure extends Model
{
    protected $table = 'hd_product_customdraw_figure';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
