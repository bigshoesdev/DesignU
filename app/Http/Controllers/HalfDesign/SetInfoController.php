<?php

namespace App\Http\Controllers\HalfDesign;

use App\HDProductSize;
use App\HDProduct;
use App\HDProductImg;
use Illuminate\Http\Request;
use App\Http\Requests\HalfDesignSetInfoRequest;
use App\Http\Controllers\Controller;
use Sentinel;

class SetInfoController extends Controller
{
    public function uploadMainImg(Request $req)
    {
        if ($req->hasFile('img')) {
            $file = $req->file('img');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            try {
                $file->move('./uploads/tmp', $fileName);
                return json_encode([
                    'success' => true,
                    'url' => 'uploads/tmp/' . $fileName
                ]);
            } catch (Exception $e) {
            }
        }
        return json_encode([
            'success' => false
        ]);
    }

    public function uploadSubImg(Request $req)
    {
        if ($req->file('img')) {
            $index = 0;
            $urls = array();
            foreach ($req->file('img') as $file) {
                if (!empty($file)) {
                    $fileName = time() . '-' . $index++ . '.' . $file->getClientOriginalExtension();
                    try {
                        $file->move('./uploads/tmp', $fileName);
                        array_push($urls, 'uploads/tmp/' . $fileName);
                    } catch (Exception $e) {
                    }
                }
            }
            return json_encode([
                'success' => true,
                'urls' => $urls
            ]);
        }
        return json_encode([
            'success' => false
        ]);
    }

    public function saveInfo(HalfDesignSetInfoRequest $request)
    {
        if ($request->get('productID') > 0) {
            $product = HDProduct::find($request->get('productID'));
            $deletedSubImages = $product->deleteSubImages()->toArray();
            $deletedMainImage = $product->deleteMainImage();
            $product->title = $request->get('title');
            $product->crowding = $request->get('crowding');
            $product->description = $request->get('description');
            $product->price = $request->get('price');
            $product->date = $request->get('date');
            $product->category_id = $request->get('category_id');
        } else {
            $product = new HDProduct($request->except('size', 'mainimg', 'subimg', 'productID'));
            $product->register_step = 1; // first register info step;
            $product->created_by = Sentinel::getUser()->id;
            $product->register_date = date('Y-m-d H:i:s');
            $product->brand_id = Sentinel::getUser()->getBrand()->id;
            $product->sale_num = 0;
            $product->status = 1;
            $product->active = 0;
            $product->is_pending = 1;
            $product->pending_success = 0;
        }
        if ($product->save()) {
            if ($request->has('mainimg')) {
                $fileUrl = $request->get('mainimg');
                $fileName = basename($fileUrl);
                $sourcePath = "./" . $fileUrl;
                $destPath = './uploads/halfdesign/product/' . $product->id . '/';
                if (!\File::exists($destPath)) {
                    \File::makeDirectory($destPath);
                }
                $destPath = $destPath . $fileName;
                \File::move($sourcePath, $destPath);

                $productImg = new HDProductImg();
                $productImg->url = 'uploads/halfdesign/product/' . $product->id . '/' . $fileName;
                $productImg->product_id = $product->id;
                $productImg->role = 1;                                                                   // Main
                $productImg->save();

                if (isset($deletedMainImage))
                    if ($deletedMainImage->url != $fileUrl)
                        unlink($deletedMainImage->url);
            }

            if ($request->has('subimg')) {
                $subimg = $request->get('subimg');

                foreach ($subimg as $img) {
                    $fileUrl = $img;
                    $fileName = basename($fileUrl);
                    $sourcePath = "./" . $fileUrl;
                    $destPath = './uploads/halfdesign/product/' . $product->id . '/';
                    if (!\File::exists($destPath)) {
                        \File::makeDirectory($destPath);
                    }
                    $destPath = $destPath . $fileName;
                    \File::move($sourcePath, $destPath);
                    $productImg = new HDProductImg();
                    $productImg->url = 'uploads/halfdesign/product/' . $product->id . '/' . $fileName;
                    $productImg->product_id = $product->id;
                    $productImg->role = 0;                                                               // Sub Image
                    $productImg->save();

                    if (isset($deletedSubImages)) {
                        foreach ($deletedSubImages as $index => $deletedSubImage) {
                            if ($deletedSubImage['url'] == $fileUrl) {
                                array_splice($deletedSubImages, $index, 1);
                            }
                        }
                    }
                }

                if (isset($deletedSubImages)) {
                    foreach ($deletedSubImages as $subImage)
                        unlink($subImage['url']);
                }
            }

            if ($request->has('size') && !($request->get('productID') > 0)) {
                $size = $request->get('size');

                foreach ($size as $val) {
                    $list = explode(",", $val);

                    $productSize = new HDProductSize();

                    $productSize->product_id = $product->id;
                    $productSize->size = $list[0];
                    $productSize->shoulder = $list[1];
                    $productSize->bust = $list[2];
                    $productSize->waist = $list[3];
                    $productSize->hip = $list[4];
                    $productSize->sleeve = $list[5];

                    $productSize->save();
                }
            }

            return redirect()->route('halfdesign.setauto', $product->id);
        }
    }
}