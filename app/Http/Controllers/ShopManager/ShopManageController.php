<?php

namespace App\Http\Controllers\ShopManager;

use App\Http\Controllers\Controller;
use Sentinel;
use App\Category;

class ShopManageController extends Controller
{
    public function index()
    {
        if (!$this->checkBrandForm())
            return view('shopmanager.no_brand');
        else
            return view('shopmanager.index');
    }

    public function brandPage()
    {
        return view('shopmanager.brand');
    }

    public function productPage()
    {
        $categoryList = Category::all();

        $result = array();
        $result['categoryList'] = $categoryList;

        if (!$this->checkBrandForm())
            return view('shopmanager.no_brand');
        else
            return view('shopmanager.product', $result);
    }

    public function projectPage()
    {
        $categoryList = Category::all();

        $result = array();
        $result['categoryList'] = $categoryList;

        if (!$this->checkBrandForm())
            return view('shopmanager.no_brand');
        else
            return view('shopmanager.project', $result);
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