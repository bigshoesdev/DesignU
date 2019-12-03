<?php

namespace App;

use Illuminate\Support\Facades\Session;

class ShoppingCart
{
    public $productID;
    public $productSize;
    public $productStyle;
    public $productNum;
    public $created_at;

    public function addToCart()
    {

        $item = array();

        $item['productID'] = $this->productID;
        $item['productStyle'] = $this->productStyle;
        $item['productSize'] = $this->productSize;
        $item['productNum'] = $this->productNum;
        $item['created_at'] = date("Y-m-d H:i:s");

        Session::push('shopping-cart', $item);

//        $isNewItem = true;

//        if (Session::get('shopping-cart') != NULL) {
//            foreach (Session::get('shopping-cart') as $key => $item) {
//                if ($item['productID'] == $this->productID && $item['productSize'] == $this->productSize && $item['productStyle'] == $this->productStyle) {
//                    Session::put('shopping-cart.' . $key . '.productNum', $item['productNum'] + $this->productNum);
//                    $isNewItem = false;
//                    break;
//                }
//            }
//        }
//
//        if ($isNewItem) {
//        }
    }

    public static function getCartItem($key)
    {
        return Session::get('shopping-cart.' . $key);
    }

    public function removeAllCart()
    {
        Session::forget('shopping-cart');
    }

    public function removeCartItem($key)
    {
        Session::forget('shopping-cart.' . $key);
    }

    public function getCartList()
    {
        $list = Session::get('shopping-cart');
        if (!isset($list))
            return null;

        $data = array();
        $index = 0;
        foreach ($list as $key => $value) {
            $data[$index]['key'] = $key;
            $product = Product::find($value['productID']);
            $data[$index]['product'] = $product;
            $data[$index]['size'] = ProductSize::find($value['productSize']);
            $data[$index]['style'] = ProductStyle::find($value['productStyle']);
            $data[$index]['number'] = $value['productNum'];
            $data[$index]['total'] = $product->price * $value['productNum'];
            $data[$index]['created_at'] = $value['created_at'];
            $index++;
        }

        return $data;
    }

    public function getTotalPrice()
    {
        $list = Session::get('shopping-cart');
        if (!isset($list))
            return 0;

        $sum = 0;
        foreach ($list as $item) {
            $product = Product::find($item['productID']);
            $sum += $product->price * $item['productNum'];
        }

        return $sum;
    }
}