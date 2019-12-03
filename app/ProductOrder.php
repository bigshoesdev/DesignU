<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $table = 'product_order';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function getProduct()
    {
        return Product::find($this->product_id);
    }

    public function getDelivery() {
        $delivery = ProductOrderDelivery::where('order_id', $this->id)->first();

        if (!empty($delivery)) {
            return $delivery;
        } else
            return null;
    }

    public function getRequestExchangeReturn()
    {
        $exchangeReturn = ProductOrderExchangeReturn::where('order_id', $this->id)->first();

        if (!empty($exchangeReturn)) {
            return $exchangeReturn;
        } else
            return null;
    }

    public static function getAllProductOrderCountByProduct($productID, $date)
    {
        $productOrderList = ProductOrder::where('product_id', $productID)->where('status', 1)->whereDate('order_date', '=', $date)->get();

        return count($productOrderList);
    }

    public static function getAllProductOrderTotalPriceByProduct($productID, $date)
    {
        $totalPrice = ProductOrder::where('product_id', $productID)->where('status', 1)->whereDate('order_date', '=', $date)->sum('total_price');

        return $totalPrice;
    }

    public static function getNotDeliveredProductOrderListByProduct($productID, $date)
    {
        $productOrderList = ProductOrder::where('product_id', $productID)->where('status', 1)->where('delivered', 0)->whereDate('order_date', '=', $date)->get();

        return $productOrderList;
    }

    public static function getAllProductOrderCountByDay($brand, $date)
    {
        $productList = Product::where('brand_id', $brand->id)->where('status', 1)->get();

        $productIDAry = [];
        foreach ($productList as $product) {
            array_push($productIDAry, $product->id);
        }

        $productOrderList = ProductOrder::whereIn('product_id', $productIDAry)->where('status', 1)->whereDate('order_date', '=', $date)->get();

        return count($productOrderList);
    }

    public static function getAllProductOrderTotalPriceByDay($brand, $date)
    {
        $productList = Product::where('brand_id', $brand->id)->where('status', 1)->get();

        $productIDAry = [];
        foreach ($productList as $product) {
            array_push($productIDAry, $product->id);
        }

        $totalPrice = ProductOrder::whereIn('product_id', $productIDAry)->where('status', 1)->whereDate('order_date', '=', $date)->sum('total_price');

        return $totalPrice;
    }

    public static function getNotDeliveredProductOrderCountByDay($brand, $date)
    {
        $productList = Product::where('brand_id', $brand->id)->where('status', 1)->get();

        $productIDAry = [];
        foreach ($productList as $product) {
            array_push($productIDAry, $product->id);
        }

        $productOrderList = ProductOrder::whereIn('product_id', $productIDAry)->where('delivered', 0)->where('status', 1)->whereDate('order_date', '=', $date)->orderBy('user_id')->get();

        return count($productOrderList);
    }

    public static function getNotDeliveredProductOrderListByDay($brand, $date)
    {
        $productList = Product::where('brand_id', $brand->id)->where('status', 1)->get();

        $productIDAry = [];
        foreach ($productList as $product) {
            array_push($productIDAry, $product->id);
        }

        $productOrderList = ProductOrder::whereIn('product_id', $productIDAry)->where('delivered', 0)->where('status', 1)->whereDate('order_date', '=', $date)->orderBy('user_id')->get();

        $productOrderListByUser = array();
        foreach ($productOrderList as $productOrder) {
            if (!array_key_exists($productOrder->user_id, $productOrderListByUser)) {
                $productOrderListByUser[$productOrder->user_id] = array();
            }

            array_push($productOrderListByUser[$productOrder->user_id], $productOrder);
        }

        $data = array();

        $userNameList = array();

        foreach (array_keys($productOrderListByUser) as $id) {
            array_push($userNameList, ['id' => $id, 'name' => User::find($id)->name]);
        }

        $data['productOrderListByUser'] = $productOrderListByUser;
        $data['userNameList'] = $userNameList;
        return $data;
    }

    public static function getNotDeliveredProductOrderListByDayForExcel($brand, $date)
    {
        $productList = Product::where('brand_id', $brand->id)->where('status', 1)->get();

        $productIDAry = [];
        foreach ($productList as $product) {
            array_push($productIDAry, $product->id);
        }

        $productOrderList = ProductOrder::whereIn('product_id', $productIDAry)->where('delivered', 0)->where('status', 1)->whereDate('order_date', '=', $date)->orderBy('user_id')->get();

        return $productOrderList;
    }

    public static function getRequestExchangeReturnListByProduct($productID, $date)
    {
        $productOrderList = ProductOrder::where('product_id', $productID)->where('status', 1)->where('is_request', 1)->whereDate('order_date', '=', $date)->get();

        $exchangeProductList = array();
        $returnProductList = array();

        foreach ($productOrderList as $productOrder) {
            $exchangeReturn = $productOrder->getRequestExchangeReturn();
            if ($exchangeReturn && $exchangeReturn->is_check == 0) {
                if ($exchangeReturn->type == 'exchange')
                    array_push($exchangeProductList, $productOrder);
                else
                    array_push($returnProductList, $productOrder);
            }
        }

        return ['exchangeProductList' => $exchangeProductList, 'returnProductList' => $returnProductList];
    }

    public static function getRequestExchangeReturnListByDay($brand, $date)
    {
        $productList = Product::where('brand_id', $brand->id)->where('status', 1)->get();

        $productIDAry = [];
        foreach ($productList as $product) {
            array_push($productIDAry, $product->id);
        }

        $productOrderList = ProductOrder::whereIn('product_id', $productIDAry)->where('status', 1)->where('is_request', 1)->whereDate('order_date', '=', $date)->get();

        $exchangeProductList = array();
        $returnProductList = array();

        foreach ($productOrderList as $productOrder) {
            $exchangeReturn = $productOrder->getRequestExchangeReturn();
            if ($exchangeReturn && $exchangeReturn->is_check == 0) {
                if ($exchangeReturn->type == 'exchange')
                    array_push($exchangeProductList, $productOrder);
                else
                    array_push($returnProductList, $productOrder);
            }
        }


        $exchangeProductOrderListByUser = array();
        foreach ($exchangeProductList as $exchangeProductOrder) {
            if (!array_key_exists($exchangeProductOrder->user_id, $exchangeProductOrderListByUser)) {
                $exchangeProductOrderListByUser[$exchangeProductOrder->user_id] = array();
            }

            array_push($exchangeProductOrderListByUser[$exchangeProductOrder->user_id], $exchangeProductOrder);
        }

        $exchangeProductOrderData = array();

        $userNameList = array();

        foreach (array_keys($exchangeProductOrderListByUser) as $id) {
            array_push($userNameList, ['id' => $id, 'name' => User::find($id)->name]);
        }

        $exchangeProductOrderData['productOrderListByUser'] = $exchangeProductOrderListByUser;
        $exchangeProductOrderData['userNameList'] = $userNameList;


        $returnProductOrderListByUser = array();
        foreach ($returnProductList as $returnProductOrder) {
            if (!array_key_exists($returnProductOrder->user_id, $returnProductOrderListByUser)) {
                $returnProductOrderListByUser[$returnProductOrder->user_id] = array();
            }

            array_push($returnProductOrderListByUser[$returnProductOrder->user_id], $returnProductOrder);
        }

        $returnProductOrderData = array();

        $userNameList = array();

        foreach (array_keys($returnProductOrderListByUser) as $id) {
            array_push($userNameList, ['id' => $id, 'name' => User::find($id)->name]);
        }

        $returnProductOrderData['productOrderListByUser'] = $returnProductOrderListByUser;
        $returnProductOrderData['userNameList'] = $userNameList;


        return ['exchangeProductList' => $exchangeProductOrderData, 'returnProductList' => $returnProductOrderData];
    }
}
