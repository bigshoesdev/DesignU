<?php

namespace App\Http\Controllers\HalfDesign;

use App\Http\Controllers\Controller;
use App\HDProduct;
use App\HDProductPrint;
use App\HDProductPrintPattern;
use App\HDProductPrintGroup;
use Illuminate\Http\Request;
use Sentinel;

class SetPrintController extends Controller {

    public function savePrinting(Request $req)
    {
        $productID = $req->get('productID');

        $product = HDProduct::find($productID);

        if ($product->register_step == 2)
            $product->register_step = 3;

        $product->save();

        $product->deletePrinting();

        $hdProductPrint = new HDProductPrint();

        $hdProductPrint->product_id = $productID;
        $hdProductPrint->size_id = $req->get('sizeID');
        $hdProductPrint->textile_width = $req->get('textileWidth');
        $hdProductPrint->textile_unit = $req->get('textileUnit');
        $hdProductPrint->textile_height = $req->get('textileHeight');
        $hdProductPrint->preview_width = $req->get('previewWidth');
        $hdProductPrint->unit_base = $req->get('unitBase');
        $hdProductPrint->save();

        foreach ($req->get('patterns') as $printPattern) {
            $hdProductPrintPattern = new HDProductPrintPattern();

            $hdProductPrintPattern->print_id = $hdProductPrint->id;
            $hdProductPrintPattern->model = $printPattern['model'];
            $hdProductPrintPattern->pattern_mapping_id = $printPattern['model'] == 'image' ? $printPattern['patternMappingID'] : 0;
            $hdProductPrintPattern->left = $printPattern['left'];
            $hdProductPrintPattern->top = $printPattern['top'];
            $hdProductPrintPattern->model = $printPattern['model'];
            $hdProductPrintPattern->angle = $printPattern['angle'];
            $hdProductPrintPattern->scale_x = $printPattern['scaleX'];
            $hdProductPrintPattern->scale_y = $printPattern['scaleY'];
            $hdProductPrintPattern->width = $printPattern['width'];
            $hdProductPrintPattern->height = $printPattern['height'];
            $hdProductPrintPattern->color = $printPattern['color'];
            $hdProductPrintPattern->flip_x = $printPattern['flipX'];
            $hdProductPrintPattern->flip_y = $printPattern['flipY'];

            $hdProductPrintPattern->save();
        }

        if($req->get('groups')) {
            foreach ($req->get('groups') as $printGroup) {
                $hdProductPrintGroup = new HDProductPrintGroup();

                $hdProductPrintGroup->print_id = $hdProductPrint->id;
                $hdProductPrintGroup->pattern_indexs = json_encode($printGroup['patternIndexs']);

                $hdProductPrintGroup->save();
            }
        }

        $data = array();
        $data['success'] = true;
        $data['nextUrl'] = route('halfdesign.index');

        return json_encode($data);
    }

    public function getProductInfoPrint(Request $req)
    {
        $product = HDProduct::find($req->get('productID'));
        $sizes = $product->getSizes()->get();

        $data = array();
        $data["product"] = $product;
        $data["sizes"] = $sizes;
        $data["patterns"] = $product->getPatterns()->get();
        $data["patternImages"] = $product->getPatternImages();
        $data['mappedPatterns'] = $product->getMappedPatterns()->get();
        $data['printPatterns'] = $product->getPrintPatterns();
        $data['printGroups'] = $product->getPrintGroups();
        $print = $product->getPrinting()->get();
        if (count($print) > 0) {
            $data['printing'] = $print[0];
        } else {
            $data["printing"] = null;
        }

        return json_encode($data);
    }
}