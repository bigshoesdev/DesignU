<?php

namespace App\Http\Controllers\Shopping;

use App\BrandDesignSource;
use App\BrandDesignSourceDownload;
use App\Http\Controllers\Controller;
use App\ProductStyle;
use App\User;
use Sentinel;
use App\Category;
use App\Brand;
use App\Product;
use App\ProductSize;
use App\ProdutStyle;
use App\UserAddress;
use App\ProductOrder;
use Illuminate\Http\Request;
use App\ShoppingCart;

class ShoppingController extends Controller
{
    public function index()
    {
        $productList = Product::where('status', 1)->where('active', 1)->paginate(8);

        $data = array();
        $data['productList'] = $productList;
        return view('shopping.index', $data);
    }

    public function brandListPage()
    {
        $brandList = Brand::where('is_complete', 1)->get();

        $data = array();
        $data['brandList'] = $brandList;

        return view('shopping.brandlist', $data);
    }

    public function brandPage($id)
    {
        $brand = Brand::where('id', $id)->get()->first();

        $data = array();
        $data['brand'] = $brand;
        $data['designSources'] = $brand->getDesignSources()->get();
        $data['productList'] = Product::where('brand_id', $brand->id)->where('status', 1)->where('active', 1)->paginate(6);
        return view('shopping.brand', $data);
    }

    public function categoryListPage()
    {
        $categoryList = Category::all();

        $data = array();
        $data['categoryList'] = $categoryList;

        return view('shopping.categorylist', $data);
    }

    public function categoryPage($id)
    {
        $category = Category::where('id', $id)->get()->first();

        $data = array();
        $data['category'] = $category;
        $data['productList'] = Product::where('category_id', $category->id)->where('status', 1)->where('active', 1)->paginate(6);
        return view('shopping.category', $data);
    }

    public function productPage($id)
    {
        $product = Product::find($id);
        $brand = Brand::find($product->brand_id);

        $data = array();
        $data['product'] = $product;
        $data['brand'] = $brand;
        return view('shopping.product', $data);
    }

    public function addCart(Request $req)
    {
        $productID = $req->get('id');
        $productSize = $req->get('size');
        $productStyle = $req->get('style');
        $productNum = $req->get('num');

        $cart = new ShoppingCart();
        $cart->productID = $productID;
        $cart->productSize = $productSize;
        $cart->productStyle = $productStyle;
        $cart->productNum = $productNum;

        $cart->addToCart();

        return json_encode(['success' => true]);
    }

    public function myCartPage()
    {
        $data = array();

        $cart = new ShoppingCart();
        $cartList = $cart->getCartList();

        $data['cartList'] = $cartList;
        $data['totalPrice'] = $cart->getTotalPrice();

        return view('shopping.mycart', $data);
    }

    public function removeCartItem($id)
    {
        $cart = new ShoppingCart();
        $cart->removeCartItem($id);
        return redirect()->route('shopping.mycart.list');
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

        if ($req->has('cartID')) {
            $cartID = $req->get('cartID');

            $cartItem = ShoppingCart::getCartItem($cartID);

            $data['product'] = Product::find($cartItem['productID']);
            $data['productimg'] = $data['product']->getMainImage();
            $data['productStyle'] = ProductStyle::find($cartItem['productStyle']);
            $data['productSize'] = ProductSize::find($cartItem['productSize']);
            $data['productNum'] = $cartItem['productNum'];
            $data['totalPrice'] = $data['product']->price * $cartItem['productNum'];
            $data['cartID'] = $cartID;
            $data['orderNo'] = (new \DateTime())->getTimestamp() . $data['product']->id . $data['productStyle']->id . $data['productSize']->id . $user->id;
            $data['orderDate'] = date('Y-m-d H:i:s');
            $data['user'] = $user;
            $data['userAddress'] = UserAddress::getSelectedAddress($user);
            $data['success'] = true;

            return json_encode($data);
        }

        return json_encode(['success' => false]);
    }

    public function order(Request $req)
    {
        $data = array();
        $user = Sentinel::getUser();

        if ($req->has('cartID')) {
            $cartID = $req->get('cartID');

            $cartItem = ShoppingCart::getCartItem($cartID);

            $product = Product::find($cartItem['productID']);
            $productNum = $cartItem['productNum'];

            $totalPrice = $product->price * $productNum;

            $balance = $user->getBalance();
            if ($totalPrice < $balance->amount) {
                $balance->amount = $balance->amount - $totalPrice;
                $balance->save();

                $productOrder = new ProductOrder();
                $productOrder->order_no = $req->get('no');
                $productOrder->order_date = $req->get('date');
                $productOrder->product_id = $product->id;
                $productOrder->product_size = $cartItem['productSize'];
                $productOrder->product_style = $cartItem['productStyle'];
                $productOrder->product_amount = $cartItem['productNum'];
                $productOrder->user_id = $user->id;
                $productOrder->note = $req->get('note') != "" ? $req->get('note') : "";
                $productOrder->total_price = $totalPrice;
                $productOrder->user_address_id = $req->get('address');
                $productOrder->delivered = 0;
                $productOrder->status = 1;

                $productOrder->save();

                // increase product sale num
                $product->sale_num = $product->sale_num + $cartItem['productNum'];
                $product->save();

                // remove cart item
                $cart = new ShoppingCart();
                $cart->removeCartItem($cartID);
                $data['success'] = true;
            } else {
                $data['success'] = false;
                $data['msg'] = "Your balance is not enough for this order. Please charge for this order.";
            }

            return json_encode($data);
        }

        return json_encode(['success' => false]);
    }

    public function downloadDesignSource(Request $req)
    {
        $id = $req->get('id');

        $user = Sentinel::getUser();
        $brandDesignSource = BrandDesignSource::find($id);
        $totalPrice = $brandDesignSource->price;

        $balance = $user->getBalance();
        if ($totalPrice < $balance->amount) {
            $balance->amount = $balance->amount - $totalPrice;
            $balance->save();

            $destBrand = Brand::find($brandDesignSource->brand_id);

            $destUser = User::find($destBrand->user_id);

            $destBalance = $destUser->getBalance();
            $destBalance->amount = $destBalance->amount + $totalPrice;
            $destBalance->save();

            $brandDesignSourceDownload = new BrandDesignSourceDownload;
            $brandDesignSourceDownload->brand_design_source_id = $id;
            $brandDesignSourceDownload->user_id = $destUser->id;
            $brandDesignSourceDownload->save();

            $data['success'] = true;
            $data['url'] = $brandDesignSource->url;
        } else {
            $data['success'] = false;
            $data['msg'] = "Your balance is not enough for this order. Please charge for this order.";
        }
        return json_encode($data);
    }
}