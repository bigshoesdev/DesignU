<?php

namespace App\Http\Controllers\HalfDesign;

use App\HDProduct;
use App\Http\Controllers\Controller;
use App\MySizeSetting;
use Illuminate\Http\Request;
use App\MyFolder;
use App\MyFile;
use App\HDProductCustomDraw;

use Sentinel;

class PrintPaperController extends Controller
{
    public function getProductInfoPrintPaper(Request $req)
    {
        $customDraw = HDProductCustomDraw::find($req->get('customDrawID'));
        $hdProduct = HDProduct::find($customDraw->product_id);
        $sizes = $hdProduct->getSizes()->get();

        $data = array();
        $data["product"] = $hdProduct;
        $data["category"] = $hdProduct->getCategory();
        $data["sizes"] = $sizes;
        $data["designs"] = $hdProduct->getDesigns()->get();
        $data["designImages"] = $hdProduct->getDesignImages();
        $data["patterns"] = $hdProduct->getPatterns()->get();
        $data["patternImages"] = $hdProduct->getPatternImages();
        foreach ($data['patternImages'] as $patternImages) {
            foreach ($patternImages as $patternImage) {
                $patternImage["size"] = getimagesize('./' . $patternImage->url);
            }
        }
        $data['mappedPatterns'] = $hdProduct->getMappedPatterns()->get();
        $data['mappedImages'] = $hdProduct->getMappedDesignImages();
        $data['printPatterns'] = $hdProduct->getPrintPatterns();
        $data['printGroups'] = $hdProduct->getPrintGroups();
        $data['customDrawFigures'] = $customDraw->getFigures()->get();
        $data["customDrawFigureImages"] = $customDraw->getFigureImages();
        $data['customDrawColors'] = $customDraw->getColors()->get();
        $data['customDrawSize'] = MySizeSetting::where('id', $customDraw->size_id)->first();
        $print = $hdProduct->getPrinting()->get();
        if (count($print) > 0) {
            $data['printing'] = $print[0];
        } else {
            $data["printing"] = null;
        }
        return json_encode($data);
    }

    public function printCustomDrawImage(Request $req)
    {
        if ($req->has('customDrawID')) {
            $customDrawID = $req->get('customDrawID');

            $customDraw = HDProductCustomDraw::find($customDrawID);
            $product = HDProduct::find($customDraw->product_id);


            if ($customDraw->is_pay == 0 || $product->is_pending == 0 || $customDraw->created_by != Sentinel::getUser()->id) {
                return json_encode([
                    'success' => false
                ]);
            }

            $customDrawOrder = $customDraw->getOrder()->get()[0];
            $customDrawOrder->product_size = $req->get('sizeID');
            $customDrawOrder->save();

            $product = $customDraw->getProduct();

            $folder = MyFolder::where(['user_id' => $product->created_by, 'name' => "product-" . $product->id])->first();

            if (empty($folder)) {
                $folder = new MyFolder;

                $folder->name = "product-" . $product->id;
                $folder->user_id = $product->created_by;
                $folder->downloadable = 1;                          //allowed;

                $folder->save();
            }

            if ($req->hasFile('img')) {
                $file = $req->file('img');

                $fileName = $customDrawOrder->order_no . '.png';

                $fileModel = MyFile::where(['user_id' => $product->created_by, 'name' => $fileName])->first();

                if (empty($fileModel)) {
                    $fileModel = new MyFile();
                    $fileModel->folder_id = $folder->id;
                    $fileModel->user_id = $product->created_by;
                    $fileModel->name = $fileName;
                    $fileModel->downloadable = 1;
                    $fileModel->url = "uploads/myfile/" . $fileModel->user_id . "/" . $fileName;
                    $fileModel->save();
                }

                $destFolderPathPath = 'uploads/myfile/' . $fileModel->user_id;

                if (!\File::exists($destFolderPathPath)) {
                    \File::makeDirectory($destFolderPathPath);
                }

                try {
                    $file->move($destFolderPathPath, $fileName);
                } catch (Exception $e) {
                }
            }
        }

        return json_encode([
            'success' => true
        ]);
    }
}