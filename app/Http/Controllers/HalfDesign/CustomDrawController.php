<?php

namespace App\Http\Controllers\HalfDesign;

use App\HDProduct;
use App\HDProductCustomDrawColor;
use App\HDProductCustomDraw;
use App\HDProductCustomDrawFigure;
use App\HDProductCustomDrawFigureImg;
use App\HDProductCustomDrawPrintImg;
use App\Http\Controllers\Controller;
use App\UserAddress;
use App\HDProductCustomDrawOrder;
use Sentinel;

use Illuminate\Http\Request;

class CustomDrawController extends Controller
{
    public function saveCustomDraw(Request $req)
    {
        $data = array();
        if($req->has('data')){
            $hdProductCustomDraw = $this->makeCustomDraw($req->get('data'));
            $data['success'] = true;
            $data['customDrawID'] = $hdProductCustomDraw->id;
        }else
        $data['success'] = false;

        return json_encode($data);
    }

    public function getProductInfoCustomDraw(Request $req)
    {
        $product = HDProduct::find($req->get('productID'));
        $data = array();
        $data["product"] = $product;
        $data["designs"] = $product->getDesigns()->get();
        $data["designImages"] = $product->getDesignImages();
        $data['mappedPatterns'] = $product->getMappedPatterns()->get();
        $data['mappedImages'] = $product->getMappedDesignImages();

        $customDrawID = $req->get('customDrawID');

        if ($customDrawID > 0) {
            $customDraw = HDProductCustomDraw::find($customDrawID);
            $data['customDraw'] = $customDraw;
            $data['customDrawFigures'] = $customDraw->getFigures()->get();
            $data['customDrawColors'] = $customDraw->getColors()->get();
            $data["customDrawFigureImages"] = $customDraw->getFigureImages();
        } else {
            $data["customDraw"] = null;
            $data['customDrawFigures'] = [];
        }
        return json_encode($data);
    }

    public function printCustomDraw(Request $req)
    {
        $customDraw = HDProductCustomDraw::find($req->get('customDrawID'));
        $product = HDProduct::find($customDraw->product_id);

        $customDrawPrintImgs = $customDraw->getPrintImages()->get();

        foreach ($customDrawPrintImgs as $customDrawPrintImg) {
            unlink($customDrawPrintImg->url);
            $customDrawPrintImg->delete();
        }

        $destFolderPathPath = 'uploads/halfdesign/customdraw/' . $customDraw->id;

        if (!\File::exists($destFolderPathPath)) {
            \File::makeDirectory($destFolderPathPath);
        }

        if ($req->file('img')) {
            $index = 0;
            foreach ($req->file('img') as $file) {
                if (!empty($file)) {
                    $fileName = time() . '-' . $index++ . '.jpeg';
                    try {
                        $file->move($destFolderPathPath, $fileName);
                        $hdProductCustomDrawPrintImg = new HDProductCustomDrawPrintImg;
                        $hdProductCustomDrawPrintImg->customdraw_id = $customDraw->id;
                        $hdProductCustomDrawPrintImg->url = $destFolderPathPath . "/" . $fileName;
                        $hdProductCustomDrawPrintImg->save();
                    } catch (Exception $e) {
                    }
                }
            }
        }

        $data = array();
        $data['success'] = true;
        $data['nextUrl'] = route('halfdesign.productlist');

        if ($customDraw->is_pay > 0 && $product->is_pending == 1 && $customDraw->size_id > 0) {
            $data['nextUrl'] = route('halfdesign.printpaper.print', ['customDrawID' => $customDraw->id]);
        }

        return json_encode($data);
    }

    public function payInfo(Request $req)
    {
        $data = array();
        $user = Sentinel::getUser();

        $isFilledData = $user->isFullyFilledForPay();

        if (!$isFilledData['isFilled']) {
            if ($isFilledData['type'] == 'setting')
                return response(json_encode(['success' => false, 'url' => route('mypage.setting')]), 408);
            else
                return response(json_encode(['success' => false, 'url' => route('mypage.address')]), 408);
        }

        if ($req->has('productID')) {
            $productID = $req->get('productID');

            $data['product'] = HDProduct::find($productID);
            $data['productimg'] = $data['product']->getMainImage();
            $data['totalPrice'] = $data['product']->price;
            $data['orderNo'] = (new \DateTime())->getTimestamp() . $data['product']->id . $user->id;
            $data['orderDate'] = date('Y-m-d H:i:s');
            $data['user'] = $user;
            $data['userAddress'] = UserAddress::getSelectedAddress($user);
            $data['success'] = true;

            return json_encode($data);
        }

        return json_encode(['success' => false]);
    }

    public function pay(Request $req)
    {
        $user = Sentinel::getUser();

        if ($req->has('data') && $req->has('order')) {
            $data = $req->get('data');
            $order = $req->get('order');

            $hdProductCustomDraw = $this->makeCustomDraw($data);
            $hdProduct = HDProduct::find($hdProductCustomDraw->product_id);

            if ($hdProductCustomDraw->is_pay == 0) {
                $hdProductCustomDrawOrder = new HDProductCustomDrawOrder;

                $hdProductCustomDrawOrder->customdraw_id = $hdProductCustomDraw->id;
                $hdProductCustomDrawOrder->note = $order['note'] != "" ? $order['note'] : "";
                $hdProductCustomDrawOrder->order_no = $order['no'];
                $hdProductCustomDrawOrder->order_date =$order['date'];
                $hdProductCustomDrawOrder->user_address_id =$order['addressID'];
                $hdProductCustomDrawOrder->user_id = Sentinel::getUser()->id;
                $hdProductCustomDrawOrder->total_price = $hdProduct->price;
                $hdProductCustomDrawOrder->delivered = 0;
                $hdProductCustomDrawOrder->status = 1;

                $hdProductCustomDrawOrder->save();

                $hdProductCustomDraw->is_pay = 1;
                $hdProductCustomDraw->save();
            }

            $totalPrice = $hdProduct->price;

            $balance = $user->getBalance();
            if ($totalPrice < $balance->amount) {
                $balance->amount = $balance->amount - $totalPrice;
                $balance->save();

                // increase product sale num
                $hdProduct->sale_num = $hdProduct->sale_num + 1;
                $hdProduct->save();

                $data['success'] = true;
                $data['customDraw'] = $hdProductCustomDraw;
            } else {
                $data['success'] = false;
                $data['msg'] = "Your balance is not enough for this order. Please charge for this order.";
            }

            return json_encode($data);
        }

        return json_encode(['success' => false, 'msg' => 'Network Error']);
    }

    public function makeCustomDraw($data)
    {
        $productID = $data['productID'];

        $hdProductCustomDrawID = $data['customDrawID'];

        if ($hdProductCustomDrawID > 0) {
            $hdProductCustomDraw = HDProductCustomDraw::find($hdProductCustomDrawID);
            $hdProductCustomDraw->getColors()->delete();
            $hdProductCustomDraw->getFigures()->delete();
            $hdProductCustomDraw->deleteFigureImages();
        } else {
            $hdProductCustomDraw = new HDProductCustomDraw();
            $hdProductCustomDraw->product_id = $productID;
            $hdProductCustomDraw->created_by = Sentinel::getUser()->id;
            $hdProductCustomDraw->is_pay = 0;
        }

        if (array_key_exists('sizeID',$data))
            $hdProductCustomDraw->size_id = $data['sizeID'];
        else
            $hdProductCustomDraw->size_id = 0;

        $hdProductCustomDraw->preview_width = $data['previewWidth'];
        $hdProductCustomDraw->save();

        if (array_key_exists('figures',$data)) {
            foreach ($data['figures'] as $figure) {
                $hdProductCustomDrawFigure = new HDProductCustomDrawFigure();

                $hdProductCustomDrawFigure->customdraw_id = $hdProductCustomDraw->id;
                $hdProductCustomDrawFigure->design_id = $figure['designID'];
                $hdProductCustomDrawFigure->design_img_id = $figure['designImgID'];
                $hdProductCustomDrawFigure->design_img_scale = $figure['designImgScale'];
                $hdProductCustomDrawFigure->model = $figure['model'];
                if ($figure['figureImg']) {
                    $hdProductCustomDrawFigureImg = new HDProductCustomDrawFigureImg;
                    $hdProductCustomDrawFigureImg->img_type = $figure['figureImg']['type'];
                    $hdProductCustomDrawFigureImg->img_id = $figure['figureImg']['id'];
                    $hdProductCustomDrawFigureImg->customdraw_id = $hdProductCustomDraw->id;
                    $hdProductCustomDrawFigureImg->save();

                    $hdProductCustomDrawFigure->figure_img_id = $hdProductCustomDrawFigureImg->id;
                }
                $hdProductCustomDrawFigure->figure_img_scale = $figure['figureImgScale'];
                $hdProductCustomDrawFigure->offset_x = $figure['offsetX'];
                $hdProductCustomDrawFigure->offset_y = $figure['offsetY'];
                $hdProductCustomDrawFigure->width = $figure['width'];
                $hdProductCustomDrawFigure->height = $figure['height'];
                $hdProductCustomDrawFigure->scale_x = $figure['scaleX'];
                $hdProductCustomDrawFigure->scale_y = $figure['scaleY'];
                $hdProductCustomDrawFigure->flip_x = $figure['flipX'];
                $hdProductCustomDrawFigure->flip_y = $figure['flipY'];
                $hdProductCustomDrawFigure->angle = $figure['angle'];
                $hdProductCustomDrawFigure->color = $figure['color'];
                $hdProductCustomDrawFigure->text = $figure['text'];
                $hdProductCustomDrawFigure->font_family = $figure['fontFamily'];

                $hdProductCustomDrawFigure->save();
            }
        }

        if (array_key_exists('colors',$data)) {
            foreach ($data['colors'] as $color) {
                $hdProductCustomDrawColor = new HDProductCustomDrawColor();

                $hdProductCustomDrawColor->customdraw_id = $hdProductCustomDraw->id;
                $hdProductCustomDrawColor->design_id = $color['designID'];
                $hdProductCustomDrawColor->design_img_id = $color['designImgID'];
                $hdProductCustomDrawColor->mode = $color['mode'];
                $hdProductCustomDrawColor->color = $color['color'];

                $hdProductCustomDrawColor->save();
            }
        }

        return $hdProductCustomDraw;
    }
}