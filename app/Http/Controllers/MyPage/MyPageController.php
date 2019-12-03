<?php

namespace App\Http\Controllers\MyPage;

use App\HDProductCustomDraw;
use App\HDProductCustomDrawOrderExchangeReturn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductOrder;
use App\Product;
use App\BrandSNS;
use App\HDProductCustomDrawOrder;
use App\HDProduct;
use App\ProductOrderExchangeReturn;
use Sentinel;

class MyPageController extends Controller
{
    public function index()
    {
        return view('mypage.index');
    }

    public function myWorkPage()
    {
        $user = Sentinel::getUser();

        $hdCustomDraws = HDProductCustomDraw::where('created_by', $user->id)->paginate(6);
        $data['hdCustomDraws'] = $hdCustomDraws;

        return view('mypage.mywork', $data);
    }

    public function myFolderPage()
    {
        return view('mypage.myfolder');
    }

    public function myOrderPage()
    {
        $user = Sentinel::getUser();
        $hdProductCustomDrawOrders = HDProductCustomDrawOrder::where('user_id', $user->id)->where('status', 1)->get();
        $productOrders = ProductOrder::where('user_id', $user->id)->where('status', 1)->get();

        $data = array();
        $data['customDrawOrders'] = $hdProductCustomDrawOrders;
        $data['productOrders'] = $productOrders;
        return view('mypage.myorder', $data);
    }

    public function sizeSettingPage()
    {
        return view('mypage.sizesetting');
    }

    public function settingPage()
    {
        $data['user'] = Sentinel::getUser();
        return view('mypage.setting', $data);
    }

    public function addressPage()
    {
        return view('mypage.address');
    }

    public function myMoneyPage()
    {
        $user = Sentinel::getUser();
        $balance = $user->getBalance();

        $data = array();
        $data['balance'] = $balance;
        return view('mypage.mymoney', $data);
    }

    public function exchangeReturn(Request $req)
    {
        if ($req->has('orderID')) {
            $orderID = $req->get('orderID');
            $description = $req->get('description');
            $type = $req->get('type');
            $modelType = $req->get('model_type');

            if ($modelType == 'halfdesign') {
                $hdProductCustomDrawOrder = HDProductCustomDrawOrder::find($orderID);
                $hdProductCustomDrawOrder->is_request = 1;
                $hdProductCustomDrawOrder->save();

                $exchangeReturn = new HDProductCustomDrawOrderExchangeReturn();

                $exchangeReturn->type = $type;
                $exchangeReturn->order_id = $orderID;
                $exchangeReturn->user_description = $description;
                $exchangeReturn->client_description = '';
                $exchangeReturn->is_agree = 0;
                $exchangeReturn->is_check = 0;

                $exchangeReturn->save();
            } else {
                $productOrder = ProductOrder::find($orderID);
                $productOrder->is_request = 1;
                $productOrder->save();

                $exchangeReturn = new ProductOrderExchangeReturn;

                $exchangeReturn->type = $type;
                $exchangeReturn->order_id = $orderID;
                $exchangeReturn->user_description = $description;
                $exchangeReturn->client_description = '';
                $exchangeReturn->is_agree = 0;
                $exchangeReturn->is_check = 0;

                $exchangeReturn->save();
            }
            return json_encode(['success' => true]);
        } else
            return json_encode(['success' => false]);
    }

    public function contactInfo(Request $req)
    {
        $data = array();
        if ($req->has('orderID')) {
            $orderID = $req->get('orderID');
            $type = $req->get('type');

            if ($type == 'shopping') {
                $order = ProductOrder::find($orderID);
                $product = Product::find($order->product_id);
                $brandSNSs = BrandSNS::where('brand_id', $product->brand_id)->get();

                $data['success'] = true;
                $data['brandSNSList'] = $brandSNSs;
            } else {
                $order = HDProductCustomDrawOrder::find($orderID);
                $customDraw = HDProductCustomDraw::find($order->customdraw_id);
                $product = HDProduct::find($customDraw->product_id);
                $brandSNSs = BrandSNS::where('brand_id', $product->brand_id)->get();

                $data['success'] = true;
                $data['brandSNSList'] = $brandSNSs;
            }
        } else
            $data['success'] = false;

        return json_encode($data);
    }
}