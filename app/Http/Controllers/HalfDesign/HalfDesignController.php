<?php

namespace App\Http\Controllers\HalfDesign;

use App\HDProductCustomDraw;
use App\Category;
use App\HDProduct;
use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;

class HalfDesignController extends Controller
{
    public function index()
    {
        return view('halfdesign.index');
    }

    public function printPaperPage($customDrawID)
    {
        $customDraw = HDProductCustomDraw::find($customDrawID);

        $product = HDProduct::find($customDraw->product_id);
        $sizes = $product->getSizes()->get();

        $data = array();
        $data["customDraw"] = $customDraw;
        $data["sizes"] = $sizes;

        return view('halfdesign.printpaper', $data);
    }

    public function printCustomDrawPage($customDrawID) {
        $customDraw = HDProductCustomDraw::find($customDrawID);

        $product = HDProduct::find($customDraw->product_id);
        $sizes = $product->getSizes()->get();

        $data = array();
        $data["customDraw"] = $customDraw;
        $data["sizes"] = $sizes;

        return view('halfdesign.printcustomdraw', $data);
    }

    public function printImage(Request $req)
    {
        if ($req->hasFile('img')) {
            $file = $req->file('img');
            $fileName = time() . '.png';
            try {
                $file->move('./uploads/tmp', $fileName);
                return json_encode([
                    'success' => true,
                    'url' => "uploads/tmp/" . $fileName
                ]);
            } catch (Exception $e) {
            }
        }
        return json_encode([
            'success' => false
        ]);
    }

    public function customDrawPage($productID, $customDrawID = 0)
    {
        $data = array();

        $data["productID"] = $productID;
        $data['customDrawID'] = $customDrawID;
        $customDraw = HDProductCustomDraw::find($customDrawID);

        if ($customDraw) {
            if ($customDraw->created_by == Sentinel::getUser()->id) {
                $data['customDraw'] = $customDraw;
                return view('halfdesign.customdraw', $data);
            } else {
                abort(401);
            }
        }

        return view('halfdesign.customdraw', $data);
    }

    public function setInfoPage($id = 0)
    {
        if (!$this->checkBrandForm())
            return view('shopmanager.no_brand');
        else {
            if ($id) {
                $product = HDProduct::find($id);

                if ($product->created_by != Sentinel::getUser()->id)
                    abort(401);
            } else {
                $product = null;
            }

            $categoryList = Category::all();

            $result = array();
            $result['categoryList'] = $categoryList;
            $result['product'] = $product;

            return view('halfdesign.setinfo', $result);
        }
    }

    public function setAutoPage($id)
    {
        if ($id) {
            $product = HDProduct::find($id);

            if ($product->created_by != Sentinel::getUser()->id)
                abort(401);
        } else {
            $product = null;
        }

        $data = array();
        $data["product"] = $product;

        return view('halfdesign.setauto', $data);
    }

    public function setPrintPage($id)
    {
        if ($id) {
            $product = HDProduct::find($id);

            if ($product->created_by != Sentinel::getUser()->id)
                abort(401);
        } else {
            $product = null;
        }

        $sizes = $product->getSizes()->get();

        $data = array();
        $data["product"] = $product;
        $data["sizes"] = $sizes;

        return view('halfdesign.setprint', $data);
    }

    public function productListPage()
    {
        $data = array();

        $hdProducts = HDProduct::where('register_step', '=', '3')->where('is_pending',1)->where('status', 1)->where('active', 1)->paginate(6);
        $data['products'] = $hdProducts;

        return view('halfdesign.productlist', $data);
    }

    public function categoryListPage() {
        $categoryList = Category::all();

        $data = array();
        $data['categoryList'] = $categoryList;

        return view('halfdesign.categorylist', $data);
    }

    public function brandListPage()
    {

        $brandList = Brand::where('is_complete', 1)->get();

        $data = array();
        $data['brandList'] = $brandList;

        return view('halfdesign.brandlist', $data);
    }

    public function brandPage($id)
    {
        $brand = Brand::where('id', $id)->get()->first();

        $data = array();
        $data['brand'] = $brand;
        $data['designSources'] = $brand->getDesignSources()->get();
        $data['products'] = HDProduct::where('brand_id', $brand->id)->where('is_pending',1)->where('status', 1)->where('active', 1)->paginate(4);
        return view('halfdesign.brand', $data);
    }

    public function categoryPage($id)
    {
        $category = Category::where('id', $id)->get()->first();

        $data = array();
        $data['category'] = $category;
        $data['products'] = HDProduct::where('category_id', $category->id)->where('is_pending',1)->where('status', 1)->where('active', 1)->paginate(6);
        return view('halfdesign.category', $data);
    }

    public function subImgViewPage($id)
    {
        $product = HDProduct::find($id);

        $data = array();
        $data["subImages"] = $product->getSubImages();
        $data["product"] = $product;

        return view('halfdesign.subimgview', $data);
    }

    public function crowdingViewPage($id)
    {
        $product = HDProduct::find($id);

        $data = array();
        $data["product"] = $product;

        return view('halfdesign.crowdingview', $data);
    }

    public function imageSelectPage()
    {
        return view('partial.halfdesign-imageselect');
    }

    public function brandDesignSourcePage() {
        return view('partial.halfdesign-branddesignsource');
    }


    public function sizeSelectPage()
    {
        return view('partial.halfdesign-sizeselect');
    }

    public function checkBrandForm()
    {
        $brand = Sentinel::getUser()->getBrand();

        if ($brand) {
            if (!$brand->is_complete)
                return false;
            return true;
        } else
            return false;
    }
}