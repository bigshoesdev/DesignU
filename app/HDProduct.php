<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProduct extends Model
{
    protected $table = 'hd_product';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['main_img_url'];

    public function getMainImgUrlAttribute()
    {
        return HDProductImg::where('product_id', '=', $this->id)
            ->where('role', '=', 1)
            ->take(1)->get()[0]->url;
    }

    public function getSizes()
    {
        return $this->hasMany(HDProductSize::class, 'product_id');
    }

    public function getDesigns()
    {
        return $this->hasMany(HDProductDesign::class, 'product_id');
    }

    public function getPatterns()
    {
        return $this->hasMany(HDProductPattern::class, 'product_id');
    }

    public function getMainImage()
    {
        return HDProductImg::where('product_id', '=', $this->id)
            ->where('role', '=', 1)
            ->take(1)->get()[0];
    }

    public function getSubImages()
    {
        return HDProductImg::where('product_id', '=', $this->id)
            ->where('role', '!=', 1)
            ->get();
    }

    public function getPrinting()
    {
        return $this->hasOne(HDProductPrint::class, 'product_id');
    }

    public function getPatternImages()
    {
        $patterns = $this->getPatterns()->get();

        $data = [];
        foreach ($patterns as $pattern) {
            array_push($data, $pattern->getImages()->get());
        }

        return $data;
    }

    public function getDesignImages()
    {
        $designs = $this->getDesigns()->get();

        $data = [];
        foreach ($designs as $design) {
            array_push($data, $design->getImages()->get());
        }

        return $data;
    }

    public function getFirstDesignImages()
    {
        $designImages = $this->getDesignImages();

        if (count($designImages) > 0) {
            return $designImages[0];
        } else
            return array();
    }

    public function getMappedPatterns()
    {
        return $this->hasMany(HDProductPatternMapping::class, 'product_id');
    }

    public function getMappedDesignImages()
    {
        $data = array();

        $mappedPatterns = $this->getMappedPatterns()->get();

        foreach ($mappedPatterns as $mappedPattern) {
            array_push($data, $mappedPattern->getMappedDesignImages()->get());
        }

        return $data;
    }

    public function getPrintPatterns()
    {
        $print = $this->getPrinting()->get();

        if (count($print) > 0) {
            return $print[0]->getPrintPatterns()->get();
        }

        return array();
    }

    public function getPrintGroups()
    {
        $print = $this->getPrinting()->get();

        if (count($print) > 0) {
            return $print[0]->getPrintGroups()->get();
        }

        return array();
    }

    public function getCategory()
    {
        return Category::where('id', $this->category_id)->get()->first();
    }

    public function deleteAllMappings()
    {
        $mappedPatterns = $this->getMappedPatterns()->get();

        foreach ($mappedPatterns as $mappedPattern) {
            $mappedPattern->getMappedDesignImages()->delete();
        }
    }

    public function deleteMainImage()
    {
        $mainImage = $this->getMainImage();
        HDProductImg::where('product_id', '=', $this->id)
            ->where('role', '=', 1)
            ->delete();
        return $mainImage;
    }

    public function deleteSubImages()
    {
        $subImages = $this->getSubImages();
        HDProductImg::where('product_id', '=', $this->id)
            ->where('role', '!=', 1)
            ->delete();
        return $subImages;
    }

    public function deleteSizes()
    {
        return $this->hasMany(HDProductSize::class, 'product_id')->delete();
    }

    public function deletePrinting()
    {
        $hdPrint = $this->getPrinting()->get();

        if (count($hdPrint) > 0) {
            $hdPrint[0]->getPrintPatterns()->delete();
            $hdPrint[0]->getPrintGroups()->delete();

            $this->getPrinting()->delete();
        }
    }

    public function getPayedCustomDrawsCount() {
        return count(HDProductCustomDraw::where('product_id', $this->id)->where('is_pay', 1)->get());
    }

    public function getDateDiffWithNow() {
        $date = $this->date;
        $dteStart = new \DateTime($date);
        $dteEnd   = new \DateTime("now");

        $dteDiff  = $dteEnd->diff($dteStart);

        $day = $dteDiff->d;
        $hour = $dteDiff->h;
        $min = $dteDiff->i;

        return ['day' => $day, 'hour' => $hour, 'min' => $min];
    }
}
