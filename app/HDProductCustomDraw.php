<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductCustomDraw extends Model
{
    protected $table = 'hd_product_customdraw';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function getFigures()
    {
        return $this->hasMany(HDProductCustomDrawFigure::class, 'customdraw_id');
    }

    public function getColors()
    {
        return $this->hasMany(HDProductCustomDrawColor::class, 'customdraw_id');
    }

    public function getPrintImages() {
        return $this->hasMany(HDProductCustomDrawPrintImg::class, 'customdraw_id');
    }

    public function getFirstPrintImageURL() {
        $printImages = $this->hasMany(HDProductCustomDrawPrintImg::class, 'customdraw_id')->get();
        if(count($printImages) > 0) {
            return $printImages[0]->url;
        }
        return "";
    }

    public function getFigureImages()
    {
        $figureImages = $this->hasMany(HDProductCustomDrawFigureImg::class, 'customdraw_id')->get();

        $array = array();
        foreach($figureImages as $figureImage) {
            $figureImg = array();
            if($figureImage->img_type == 'folder') {
                $file = MyFile::find($figureImage->img_id);

                $figureImg['url'] = $file->url;
                $figureImg['id'] = $figureImage->id;
                $figureImg['fileID'] = $file->id;
                $figureImg['type'] =$figureImage->img_type;

                array_push($array, $figureImg);
            }else if($figureImage->img_type == 'designsource') {
                $file = BrandDesignSource::find($figureImage->img_id);

                $figureImg['url'] = $file->url;
                $figureImg['id'] = $figureImage->id;
                $figureImg['fileID'] = $file->id;
                $figureImg['type'] =$figureImage->img_type;

                array_push($array, $figureImg);
            }
        }

        return $array;
    }

    public function deleteFigureImages()
    {
        $this->hasMany(HDProductCustomDrawFigureImg::class, 'customdraw_id')->delete();
    }

    public function getProduct() {
        return HDProduct::find($this->product_id);
    }

    public function getOrder() {
        return $this->hasOne(HDProductCustomDrawOrder::class, 'customdraw_id');
    }
}
