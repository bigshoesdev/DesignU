<?php

namespace App\Http\Controllers\HalfDesign;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HDProduct;
use App\HDProductDesign;
use App\HDProductDesignImg;
use App\HDProductPattern;
use App\HDProductPatternImg;
use App\HDProductPatternMapping;
use App\HDProductDesignImgMapping;

class SetAutoController extends Controller
{
    public function saveMapping(Request $req)
    {
        $productID = $req->get('productID');

        $product = HDProduct::find($productID);

        if ($product->register_step == 1)
            $product->register_step = 2;

        $product->save();

        $product->deleteAllMappings();

        if ($req->has('mappedPatternList')) {
            $mappedPatternList = $req->get('mappedPatternList');
            $mappedImageList = $req->get('mappedImageList');

            foreach ($mappedPatternList as $index => $mappedPattern) {
                $hdProductPatternMapping = null;
                if ($mappedPattern['id'] > 0)
                    $hdProductPatternMapping = HDProductPatternMapping::find($mappedPattern['id']);
                else
                    $hdProductPatternMapping = new HDProductPatternMapping();

                $hdProductPatternMapping->pattern_id = $mappedPattern['patternID'];
                $hdProductPatternMapping->product_id = $productID;
                $hdProductPatternMapping->scale = $mappedPattern['scale'];
                $hdProductPatternMapping->canvas_size = $mappedPattern['canvasSize'];
                $hdProductPatternMapping->size_id = $mappedPattern['sizeID'];

                $hdProductPatternMapping->save();

                foreach ($mappedImageList[$index] as $mappedImage) {
                    $hdProductDesignImgMapping = new HDProductDesignImgMapping();

                    $hdProductDesignImgMapping->pattern_mapping_id = $hdProductPatternMapping->id;
                    $hdProductDesignImgMapping->design_id = $mappedImage['designID'];
                    $hdProductDesignImgMapping->design_img_id = $mappedImage['designImgID'];
                    $hdProductDesignImgMapping->offset_x = $mappedImage['offsetX'];
                    $hdProductDesignImgMapping->offset_y = $mappedImage['offsetY'];
                    $hdProductDesignImgMapping->angle = $mappedImage['angle'];
                    $hdProductDesignImgMapping->scale = $mappedImage['scale'];

                    $hdProductDesignImgMapping->save();

                    $hdProductDesignImg = HDProductDesignImg::find($mappedImage['designImgID']);
                    $hdProductDesignImg->save();
                }
            }

            //Delete All unused patterns
            $patterns = $product->getPatterns()->get()->toArray();
            foreach ($mappedPatternList as $mappedPattern) {
                $patternID = $mappedPattern['patternID'];
                foreach ($patterns as $index => $pattern) {
                    if ($pattern['id'] == $patternID) {
                        array_splice($patterns, $index, 1);
                        break;
                    }
                }
            }

            foreach ($patterns as $pattern) {
                $dirPath = "./uploads/halfdesign/pattern/" . $pattern['id'];
                $files = array_diff(scandir($dirPath), array('.', '..'));

                foreach ($files as $file) {
                    unlink($dirPath . '/' . $file);
                }

                rmdir($dirPath);
                $hdProductPattern = HDProductPattern::find($pattern['id']);
                $hdProductPattern->deleteImages();
                $hdProductPattern->delete();
            }
        }

        $data = array();
        $data['success'] = true;
        $data['nextUrl'] = route('halfdesign.setprint', $productID);

        return json_encode($data);
    }

    public function uploadDesignImg(Request $req)
    {
        if ($req->file('img')) {
            $index = 0;

            $design = new HDProductDesign();
            $design->product_id = $req->get('productID');
            $design->save();

            foreach ($req->file('img') as $file) {
                if (!empty($file)) {
                    $fileName = time() . '-' . $index++ . '.' . $file->getClientOriginalExtension();

                    $destPath = './uploads/halfdesign/design/' . $design->id;
                    if (!\File::exists($destPath)) {
                        \File::makeDirectory($destPath);
                    }

                    try {
                        $file->move($destPath, $fileName);
                    } catch (Exception $e) {
                    }

                    $designImg = new HDProductDesignImg();
                    $designImg->design_id = $design->id;
                    $designImg->url = 'uploads/halfdesign/design/' . $design->id . '/' . $fileName;
                    $designImg->save();
                }
            }

            return json_encode([
                'success' => true,
                'design' => json_encode($design),
                'designImages' => json_encode($design->getImages()->get())
            ]);
        }
        return json_encode([
            'success' => false
        ]);
    }

    public function uploadPatternImg(Request $req)
    {
        if ($req->file('zip')) {
            $product = HDProduct::find($req->get('productID'));

            $sizes = $product->getSizes()->get();

            $sizeNameAry = array();
            $sizeIDAry = array();

            foreach ($sizes as $size) {
                array_push($sizeNameAry, $size->size);
                array_push($sizeIDAry, $size->id);
            }

            $errors = array();
            $patterns = array();
            $patternImages = array();

            foreach ($req->file('zip') as $file) {
                if (!empty($file)) {
                    $zipFile = new \ZipArchive();

                    $zipFile->open($file);

                    $fileNameAry = array();
                    $fileNameWithExtAry = array();

                    $patternFolderName = explode('.', $file->getClientOriginalName())[0];
                    for ($i = 0; $i < $zipFile->numFiles; $i++) {
                        $stat = $zipFile->statIndex($i);
                        $fileName = explode('.', basename($stat['name']))[0];
                        $fileName = substr($fileName, 0, strpos($fileName, ' ' . $patternFolderName));

                        if (in_array($fileName, $sizeNameAry)) {
                            array_push($fileNameAry, $fileName);
                            array_push($fileNameWithExtAry, basename($stat['name']));
                        }
                    }

                    if (count($fileNameAry) != count($sizeNameAry)) {
                        array_push($errors, $file->getClientOriginalName() . " should be matching to the size box that you have inputed ");
                        continue;
                    }

                    $pattern = new HDProductPattern();
                    $pattern->product_id = $req->get('productID');
                    $pattern->name = $patternFolderName;
                    $pattern->save();

                    $destPath = './uploads/halfdesign/pattern/' . $pattern->id;

                    if (!\File::exists($destPath)) {
                        \File::makeDirectory($destPath);
                    }

                    foreach ($fileNameWithExtAry as $index => $fileName) {
                        $file = $zipFile->getFromName($fileName);
                        file_put_contents($destPath . '/' . $fileName, $file);

                        $patternImg = new HDProductPatternImg();
                        $patternImg->pattern_id = $pattern->id;
                        $patternImg->url = 'uploads/halfdesign/pattern/' . $pattern->id . '/' . $fileName;
                        $patternImg->size_id = $product->getSizes()->where('size', $fileNameAry[$index])->first()->id;

                        $patternImg->save();
                    }

                    array_push($patterns, $pattern);
                    array_push($patternImages, $pattern->getImages()->get());
                }
            }

            return json_encode([
                'success' => true,
                'patterns' => json_encode($patterns),
                'patternImages' => json_encode($patternImages),
                'errors' => json_encode($errors)
            ]);
        }
        return json_encode([
            'success' => false
        ]);
    }

    public function getProductInfoAuto(Request $req)
    {
        $product = HDProduct::find($req->get('productID'));
        $sizes = $product->getSizes()->get();

        $data = array();
        $data["product"] = $product;
        $data["sizes"] = $sizes;
        $data["designs"] = $product->getDesigns()->get();
        $data["designImages"] = $product->getDesignImages();
        $data["patterns"] = $product->getPatterns()->get();
        $data["patternImages"] = $product->getPatternImages();
        $data['mappedPatterns'] = $product->getMappedPatterns()->get();
        $data['mappedImages'] = $product->getMappedDesignImages();

        return json_encode($data);
    }

}