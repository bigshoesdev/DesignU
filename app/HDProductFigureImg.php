<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductFigureImg extends Model
{
    protected $table = 'hd_product_figure_img';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];
}
