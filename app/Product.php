<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['main_img_url'];

    public function getMainImgUrlAttribute()
    {
        return ProductImg::where('product_id', '=', $this->id)
            ->where('role', '=', 1)
            ->take(1)->get()[0]->url;
    }

    public function getSizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id');
    }

    public function getStyles()
    {
        return ProductStyle::where('product_id', '=', $this->id)->where('is_free', 0)->get();
    }

    public function getMainImage()
    {
        return ProductImg::where('product_id', '=', $this->id)
            ->where('role', '=', 1)
            ->get()->first();
    }

    public function getSubImages()
    {
        return ProductImg::where('product_id', '=', $this->id)
            ->where('role', '!=', 1)
            ->get();
    }

    public function get4MainImages()
    {
        return ProductImg::where('product_id', '=', $this->id)
            ->where('role', '!=', 1)
            ->where('is_main', '=', 1)
            ->get();
    }

    public function getOtherImages()
    {
        return ProductImg::where('product_id', '=', $this->id)
            ->where('role', '!=', 1)
            ->where('is_main', '!=', 1)
            ->get();
    }

    public function getFreeStyle()
    {
        return ProductStyle::where('product_id', '=', $this->id)->where('is_free', 1)->get()->first();
    }

    public function deleteMainImage()
    {
        $mainImage = $this->getMainImage();
        ProductImg::where('product_id', '=', $this->id)
            ->where('role', '=', 1)
            ->delete();
        return $mainImage;
    }

    public function deleteSubImages()
    {
        $subImages = $this->getSubImages();
        ProductImg::where('product_id', '=', $this->id)
            ->where('role', '!=', 1)
            ->delete();
        return $subImages;
    }

    public function deleteStyles()
    {
        ProductStyle::where('product_id', '=', $this->id)->where('is_free', 0)->delete();
    }

    public function deleteFreeStyle()
    {
        return ProductStyle::where('product_id', '=', $this->id)->where('is_free', 1)->delete();
    }

    public function deleteSizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id')->delete();
    }


}