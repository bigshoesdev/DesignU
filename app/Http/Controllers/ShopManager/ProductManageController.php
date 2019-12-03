<?php

namespace App\Http\Controllers\ShopManager;

use App\Http\Controllers\Controller;
use App\ProductOrderDelivery;
use Illuminate\Http\Request;
use App\Product;
use App\ProductSize;
use App\ProductImg;
use App\ProductStyle;
use App\ProductOrder;
use App\User;
use App\UserAddress;

use Excel;
use Sentinel;

class ProductManageController extends Controller
{
    public function uploadMainImg(Request $req)
    {
        if ($req->hasFile('img')) {
            $file = $req->file('img');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            try {
                $file->move('uploads/tmp', $fileName);
                return json_encode([
                    'success' => true,
                    'mainimgurl' => 'uploads/tmp/' . $fileName
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
                        $file->move('uploads/tmp', $fileName);
                        array_push($urls, 'uploads/tmp/' . $fileName);
                    } catch (Exception $e) {
                    }
                }
            }
            return json_encode([
                'success' => true,
                'subimgurls' => $urls
            ]);
        }
        return json_encode([
            'success' => false
        ]);
    }

    public function uploadVideo(Request $req)
    {
        if ($req->hasFile('video')) {
            $file = $req->file('video');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            try {
                $file->move('uploads/tmp', $fileName);
                return json_encode([
                    'success' => true,
                    'videourl' => 'uploads/tmp/' . $fileName
                ]);
            } catch (Exception $e) {
            }
        }
        return json_encode([
            'success' => false
        ]);
    }

    public function uploadCodingFile(Request $req)
    {
        if ($req->hasFile('excel')) {
            Excel::load($req->file('excel')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $row) {
                    if (!empty($row)) {
                        $orderID = $row['id'];
                        if ($orderID != null) {
                            $productOrder = ProductOrder::find($orderID);
                            $delivery = $productOrder->getDelivery();
                            $deliveryCompany = $row["delivery_company"];
                            $deliveryNo = $row["delivery_no"];
                            if ($delivery == null && $deliveryNo != "" && $deliveryNo != null && $deliveryCompany != "" && $deliveryCompany != null) {
                                $productOrderDelivery = new ProductOrderDelivery;
                                $productOrderDelivery->order_id = $orderID;
                                $productOrderDelivery->company = $deliveryCompany;
                                $productOrderDelivery->delivery_no = $deliveryNo;
                                $productOrderDelivery->save();
                                $productOrder->delivered = 1;
                                $productOrder->save();
                            }
                        }
                    }
                }
            });
            return json_encode([
                'success' => true
            ]);
        }

        return json_encode([
            'success' => false
        ]);
    }

    public function saveProduct(Request $req)
    {
        $product = new Product($req->except('sizes', 'videourl', 'mainimgurl', 'categoryid', 'subimgurls', 'freestyle', 'styles', 'sizes'));
        $product->active = 0;                                                                              // Open or Close
        $product->status = 1;                                                                              //Delete or not
        $product->created_by = Sentinel::getUser()->id;                                   //User
        $product->sale_num = 0;
        $product->brand_id = Sentinel::getUser()->getBrand()->id;
        $product->category_id = $req->get('categoryid');
        $product->register_date = date("Y-m-d H:i:s");

        if ($product->save()) {
            if ($req->has('sizes')) {
                $sizes = $req->get('sizes');

                foreach ($sizes as $size) {
                    $list = explode(",", $size);

                    $productSize = new ProductSize();

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

            if ($req->has('videourl')) {
                $fileUrl = $req->get('videourl');
                $fileName = basename($fileUrl);
                $sourcePath = $fileUrl;
                $destPath = 'uploads/product/' . $product->id . '/';
                if (!\File::exists($destPath)) {
                    \File::makeDirectory($destPath);
                }
                $destPath = $destPath . $fileName;
                \File::move($sourcePath, $destPath);

                $product->video_url = $destPath;

                $product->save();
            }

            if ($req->has('styles')) {
                foreach ($req->get('styles') as $style) {
                    $productStyle = new ProductStyle;

                    $productStyle->product_id = $product->id;
                    $productStyle->name = $style;
                    $productStyle->is_free = 0;                                                        // 0:not free 1: free

                    $productStyle->save();
                }
            }

            if ($req->has('freestyle') && $req->get('freestyle') != "") {
                $productStyle = new ProductStyle;
                $productStyle->product_id = $product->id;
                $productStyle->name = $req->get('freestyle');
                $productStyle->is_free = 1;                                                            // 0:not free 1: free

                $productStyle->save();
            }

            if ($req->has('mainimgurl')) {
                $fileUrl = $req->get('mainimgurl');
                $fileName = basename($fileUrl);
                $sourcePath = $fileUrl;
                $destPath = 'uploads/product/' . $product->id . '/';
                if (!\File::exists($destPath)) {
                    \File::makeDirectory($destPath);
                }
                $destPath = $destPath . $fileName;
                \File::move($sourcePath, $destPath);

                $productImg = new ProductImg();
                $productImg->url = 'uploads/product/' . $product->id . '/' . $fileName;
                $productImg->product_id = $product->id;
                $productImg->role = 1;                                                                   // Main
                $productImg->save();
            }

            if ($req->has('subimgurls')) {
                $subimgurls = $req->get('subimgurls');

                foreach ($subimgurls as $subimgurl) {
                    $fileUrl = $subimgurl['url'];
                    $fileName = basename($fileUrl);
                    $sourcePath = $fileUrl;
                    $destPath = 'uploads/product/' . $product->id . '/';
                    if (!\File::exists($destPath)) {
                        \File::makeDirectory($destPath);
                    }
                    $destPath = $destPath . $fileName;
                    \File::move($sourcePath, $destPath);
                    $productImg = new ProductImg();
                    $productImg->url = 'uploads/product/' . $product->id . '/' . $fileName;
                    $productImg->product_id = $product->id;
                    $productImg->is_main = $subimgurl['is_main'];
                    $productImg->role = 0;                                                               // Sub Image
                    $productImg->save();
                }
            }

            return json_encode([
                'success' => true
            ]);
        }
    }

    public function updateProduct(Request $req)
    {
        $product = Product::find($req->get('id'));

        $deletedSubImages = $product->deleteSubImages()->toArray();
        $deletedMainImage = $product->deleteMainImage();
        $deletedVideoUrl = $product->video_url;
        $product->deleteStyles();
        $product->deleteFreeStyle();
        $product->deleteSizes();
        $product->title = $req->get('title');
        $product->description = $req->get('description');
        $product->price = $req->get('price');
        $product->category_id = $req->get('categoryid');

        if ($product->save()) {
            if ($req->has('sizes')) {
                $sizes = $req->get('sizes');

                foreach ($sizes as $size) {
                    $list = explode(",", $size);

                    $productSize = new ProductSize();

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

            if ($req->has('videourl')) {
                $fileUrl = $req->get('videourl');
                $fileName = basename($fileUrl);
                $sourcePath = $fileUrl;
                $destPath = 'uploads/product/' . $product->id . '/';
                if (!\File::exists($destPath)) {
                    \File::makeDirectory($destPath);
                }
                $destPath = $destPath . $fileName;
                \File::move($sourcePath, $destPath);

                $product->video_url = $destPath;

                $product->save();

                if (isset($deletedVideoUrl))
                    if ($deletedVideoUrl != $fileUrl)
                        unlink($deletedVideoUrl);
            }

            if ($req->has('styles')) {
                foreach ($req->get('styles') as $style) {
                    $productStyle = new ProductStyle;

                    $productStyle->product_id = $product->id;
                    $productStyle->name = $style;
                    $productStyle->is_free = 0;                                                        // 0:not free 1: free

                    $productStyle->save();
                }
            }

            if ($req->has('freestyle') && $req->get('freestyle') != "") {
                $productStyle = new ProductStyle;
                $productStyle->product_id = $product->id;
                $productStyle->name = $req->get('freestyle');
                $productStyle->is_free = 1;                                                            // 0:not free 1: free

                $productStyle->save();
            }

            if ($req->has('mainimgurl')) {
                $fileUrl = $req->get('mainimgurl');
                $fileName = basename($fileUrl);
                $sourcePath = $fileUrl;
                $destPath = 'uploads/product/' . $product->id . '/';
                if (!\File::exists($destPath)) {
                    \File::makeDirectory($destPath);
                }
                $destPath = $destPath . $fileName;
                \File::move($sourcePath, $destPath);

                $productImg = new ProductImg();
                $productImg->url = 'uploads/product/' . $product->id . '/' . $fileName;
                $productImg->product_id = $product->id;
                $productImg->role = 1;                                                                   // Main
                $productImg->save();


                if (isset($deletedMainImage))
                    if ($deletedMainImage->url != $fileUrl)
                        unlink($deletedMainImage->url);
            }

            if ($req->has('subimgurls')) {
                $subimgurls = $req->get('subimgurls');

                foreach ($subimgurls as $subimgurl) {
                    $fileUrl = $subimgurl['url'];
                    $fileName = basename($fileUrl);
                    $sourcePath = $fileUrl;
                    $destPath = 'uploads/product/' . $product->id . '/';
                    if (!\File::exists($destPath)) {
                        \File::makeDirectory($destPath);
                    }
                    $destPath = $destPath . $fileName;
                    \File::move($sourcePath, $destPath);
                    $productImg = new ProductImg();
                    $productImg->url = 'uploads/product/' . $product->id . '/' . $fileName;
                    $productImg->product_id = $product->id;
                    $productImg->is_main = $subimgurl['is_main'];
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

            return json_encode([
                'success' => true
            ]);
        }

        return json_encode([
            'success' => false
        ]);
    }

    public function updateProductState(Request $req)
    {
        $product = Product::find($req->get('id'));
        $state = $req->get('state');
        $product->active = $state;
        $product->save();

        return json_encode([
            'success' => true
        ]);
    }

    public function deleteProduct(Request $req)
    {
        $product = Product::find($req->get('id'));
        $product->status = 0;
        $product->save();

        return json_encode([
            'success' => true
        ]);
    }

    public function copyProduct(Request $req)
    {
        $product = Product::find($req->get('id'));
        $productStyles = $product->getStyles();
        $productSizes = $product->getSizes()->get();
        $productSubImages = $product->getSubImages();
        $productMainImage = $product->getMainImage();
        $productFreeStyle = $product->getFreeStyle();

        $newProduct = $product->replicate();
        $newProduct->register_date = date("Y-m-d H:i:s");
        $newProduct->save();

        $destPath = 'uploads/product/' . $newProduct->id . '/';
        if (!\File::exists($destPath)) {
            \File::makeDirectory($destPath);
        }

        foreach ($productStyles as $productStyle) {
            $newProductStyle = $productStyle->replicate();
            $newProductStyle->product_id = $newProduct->id;
            $newProductStyle->save();
        }

        if ($productFreeStyle) {
            $newProductStyle = $productFreeStyle->replicate();
            $newProductStyle->product_id = $newProduct->id;
            $newProductStyle->save();
        }

        foreach ($productSizes as $productSize) {
            $newProductSize = $productSize->replicate();
            $newProductSize->product_id = $newProduct->id;
            $newProductSize->save();
        }

        if ($product->video_url != "") {
            $fileName = basename($product->video_url);
            $destFileUrl = "uploads/product/$newProduct->id/" . $fileName;
            copy($product->video_url, $destFileUrl);
            $newProduct->video_url = $destFileUrl;
            $newProduct->save();
        }

        foreach ($productSubImages as $productSubImage) {
            $newProductSubImage = $productSubImage->replicate();

            $fileName = basename($newProductSubImage->url);
            $destFileUrl = "uploads/product/$newProduct->id/" . $fileName;
            copy($newProductSubImage->url, $destFileUrl);

            $newProductSubImage->url = $destFileUrl;
            $newProductSubImage->product_id = $newProduct->id;
            $newProductSubImage->save();
        }

        if ($productMainImage) {
            $newProductMainImage = $productMainImage->replicate();

            $fileName = basename($newProductMainImage->url);
            $destFileUrl = "uploads/product/$newProduct->id/" . $fileName;
            copy($productMainImage->url, $destFileUrl);

            $newProductMainImage->url = $destFileUrl;
            $newProductMainImage->product_id = $newProduct->id;
            $newProductMainImage->save();
        }

        return json_encode([
            'success' => true
        ]);
    }

    public function getProducts(Request $req)
    {
        $searchKey = $req->get('searchKey');
        $orderBy = $req->get('order');
        $products = Product::where('title', 'like', "%$searchKey%")->where('brand_id', Sentinel::getUser()->getBrand()->id)->where('status', 1)->get();

        $data = array();
        $data["products"] = $products;
        $data['success'] = true;

        return $data;
    }

    public function getProduct(Request $req)
    {
        if ($req->has('id')) {
            $id = $req->get('id');

            $product = Product::find($id);
            $productStyles = $product->getStyles();
            $productSizes = $product->getSizes()->get();
            $productSubImages = $product->getSubImages();
            $productMainImage = $product->getMainImage();
            $productFreeStyle = $product->getFreeStyle();

            $data = array();

            $data['product'] = $product;
            $data['styles'] = $productStyles;
            $data['sizes'] = $productSizes;
            $data['subimgs'] = $productSubImages;
            $data['mainimg'] = $productMainImage;
            $data['freestyle'] = $productFreeStyle;

            $data['success'] = true;

            return json_encode($data);
        } else {
            return json_encode(['success' => false]);
        }
    }

    public function getProductItemInfo(Request $req)
    {
        $data = array();
        if ($req->has('productID')) {
            $productID = $req->get('productID');
            $date = date('Y-m-d');

            $data['allOrderCount'] = ProductOrder::getAllProductOrderCountByProduct($productID, $date);
            $data['allTotalPrice'] = ProductOrder::getAllProductOrderTotalPriceByProduct($productID, $date);
            $data['notDeliveredOrderList'] = ProductOrder::getNotDeliveredProductOrderListByProduct($productID, $date);
            $data['notDeliveredOrderCount'] = count($data['notDeliveredOrderList']);
            $data['success'] = true;

            return json_encode($data);
        }
    }

    public function getProductItemExchangeReturn(Request $req)
    {
        if ($req->has('productID')) {
            $productID = $req->get('productID');
            $date = date('Y-m-d');

            $data = ProductOrder::getRequestExchangeReturnListByProduct($productID, $date);
            $data['exchangeProductList'] = $data['exchangeProductList'];
            $data['returnProductList'] = $data['returnProductList'];
            $data['success'] = true;

            return json_encode($data);
        } else
            return json_encode(['success' => false]);
    }

    public function getProductAllExchangeReturn(Request $req)
    {
        if ($req->has('date')) {
            $date = $req->get('date');
        } else
            $date = date('Y-m-d');

        $brand = Sentinel::getUser()->getBrand();
        $data = ProductOrder::getRequestExchangeReturnListByDay($brand, $date);
        $data['exchangeProductList'] = $data['exchangeProductList'];
        $data['returnProductList'] = $data['returnProductList'];
        $data['success'] = true;

        return json_encode($data);
    }

    public function getProductAllInfo(Request $req)
    {
        if ($req->has('date')) {
            $date = $req->get('date');
        } else
            $date = date('Y-m-d');
        $brand = Sentinel::getUser()->getBrand();
        $data['allOrderCount'] = ProductOrder::getAllProductOrderCountByDay($brand, $date);
        $data['allTotalPrice'] = ProductOrder::getAllProductOrderTotalPriceByDay($brand, $date);
        $data['notDeliveredOrderList'] = ProductOrder::getNotDeliveredProductOrderListByDay($brand, $date);
        $data['notDeliveredOrderCount'] = ProductOrder::getNotDeliveredProductOrderCountByDay($brand, $date);
        $data['success'] = true;

        return json_encode($data);
    }

    public function getOrderInfo(Request $req)
    {
        $orderID = $req->get('orderID');

        $productOrder = ProductOrder::find($orderID);
        $user = User::find($productOrder->user_id);

        $data['product'] = Product::find($productOrder->product_id);
        $data['productimg'] = $data['product']->getMainImage();
        $data['productStyle'] = ProductStyle::find($productOrder->product_style);
        $data['productSize'] = ProductSize::find($productOrder->product_size);
        $data['productNum'] = $productOrder->product_amount;
        $data['totalPrice'] = $data['product']->price * $data['productNum'];
        $data['orderNo'] = $productOrder->order_no;
        $data['orderDate'] = $productOrder->order_date;
        $data['user'] = $user;
        $data['userAddress'] = UserAddress::find($productOrder->user_address_id);
        $data['note'] = $productOrder->note;
        $data['success'] = true;

        return json_encode($data);
    }

    public function getOrderRequestInfo(Request $req)
    {
        $orderID = $req->get('orderID');

        $productOrder = ProductOrder::find($orderID);

        $requestExchangeReturn = $productOrder->getRequestExchangeReturn();

        $data['productOrder'] = $productOrder;
        $data['requestExchangeReturn'] = $requestExchangeReturn;
        $data['success'] = true;

        return json_encode($data);
    }

    public function saveReturnRequest(Request $req)
    {
        $orderID = $req->get('orderID');

        $productOrder = ProductOrder::find($orderID);

        $requestExchangeReturn = $productOrder->getRequestExchangeReturn();

        $requestExchangeReturn->is_check = $req->get('complete');
        $requestExchangeReturn->is_agree = $req->get('agree');
        $requestExchangeReturn->client_description = $req->get('description');

        $requestExchangeReturn->save();

        if ($requestExchangeReturn->is_agree > 0) {
            $deliveryCost = $req->get('deliveryCost');

            $chargeMoney = $productOrder->total_price - $deliveryCost;

            $balance = Sentinel::getUser()->getBalance();
            $balance->amount = $balance->amount + $chargeMoney;
            $balance->save();
        } else {
            $deliveryCompany = $req->get('deliveryCompany');
            $deliveryNo = $req->get('deliveryNo');

            $delivery = $productOrder->getDelivery();
            $delivery->company = $deliveryCompany;
            $delivery->delivery_no = $deliveryNo;

            $delivery->save();
        }
        return json_encode(['success' => true]);
    }

    public function saveExchangeRequest(Request $req)
    {
        $orderID = $req->get('orderID');

        $productOrder = ProductOrder::find($orderID);

        $requestExchangeReturn = $productOrder->getRequestExchangeReturn();

        $requestExchangeReturn->is_check = $req->get('complete');
        $requestExchangeReturn->is_agree = $req->get('agree');
        $requestExchangeReturn->client_description = $req->get('description');

        $requestExchangeReturn->save();

        $deliveryCompany = $req->get('deliveryCompany');
        $deliveryNo = $req->get('deliveryNo');

        $delivery = $productOrder->getDelivery();
        $delivery->company = $deliveryCompany;
        $delivery->delivery_no = $deliveryNo;

        $delivery->save();


        return json_encode(['success' => true]);
    }

    public function downLoadNotDeliveryList(Request $req)
    {
        $notDeliveredOrderList = array();

        if ($req->has('mode')) {
            $mode = $req->get('mode');
            $productID = $req->get('productID');
            if ($mode == "item") {
                $date = date('Y-m-d');
                $notDeliveredOrderList = ProductOrder::getNotDeliveredProductOrderListByProduct($productID, $date);
            } else if ($mode == 'day') {
                if ($req->get('date') != null && $req->get('date') != "")
                    $date = $req->get('date');
                else
                    $date = date('Y-m-d');

                $brand = Sentinel::getUser()->getBrand();
                $notDeliveredOrderList = ProductOrder::getNotDeliveredProductOrderListByDayForExcel($brand, $date);
            }

            $data = array();

//            array_push($data, ["ID", "Product Name", "Product Info", "", "", "", "", "", "", "User Address", "", "", "", "", "", "Delivery Info"]);
            array_push($data, ["ID", "Product Name", "Order Number", "Style", "Size", "Amount", "", "Order Date", "", "Country", "Post Code", "Address", "HP", "Note", "", "Delivery Company", "Delivery No"]);

            foreach ($notDeliveredOrderList as $notDeliveredOrder) {
                $productName = Product::find($notDeliveredOrder->product_id)->title;
                $date = date_format(date_create($notDeliveredOrder->order_date), 'Y-m-d');
                $styleName = ProductStyle::find($notDeliveredOrder->product_style)->name;
                $sizeName = ProductSize::find($notDeliveredOrder->product_size)->size;
                $productAmount = $notDeliveredOrder->product_amount;
                $item = array();

                array_push($item, $notDeliveredOrder->id, $productName, $notDeliveredOrder->order_no, $styleName, $sizeName, $productAmount, "", $date, "");
                $userAddress = UserAddress::find($notDeliveredOrder->user_address_id);
                array_push($item, $userAddress->country, $userAddress->postcode, $userAddress->address, $userAddress->hp, $notDeliveredOrder->note, "", "");

                array_push($data, $item);
            }

            ob_end_clean();

            Excel::create('Excel', function ($excel) use ($data) {
                $excel->sheet('Order', function ($sheet) use ($data) {
                    $sheet->fromArray($data, null, 'A1', false, false);

                    for ($intRowNumber = 1; $intRowNumber <= count($data) + 1; $intRowNumber++) {
                        $sheet->setSize('A' . $intRowNumber, 10, 18);
                        $sheet->setSize('B' . $intRowNumber, 20, 18);
                        $sheet->setSize('C' . $intRowNumber, 25, 18);
                        $sheet->setSize('D' . $intRowNumber, 10, 18);
                        $sheet->setSize('E' . $intRowNumber, 10, 18);
                        $sheet->setSize('F' . $intRowNumber, 10, 18);
                        $sheet->setSize('G' . $intRowNumber, 5, 18);
                        $sheet->setSize('H' . $intRowNumber, 15, 18);
                        $sheet->setSize('I' . $intRowNumber, 5, 18);
                        $sheet->setSize('J' . $intRowNumber, 15, 18);
                        $sheet->setSize('K' . $intRowNumber, 15, 18);
                        $sheet->setSize('L' . $intRowNumber, 20, 18);
                        $sheet->setSize('M' . $intRowNumber, 15, 18);
                        $sheet->setSize('N' . $intRowNumber, 20, 18);
                        $sheet->setSize('O' . $intRowNumber, 5, 18);
                        $sheet->setSize('P' . $intRowNumber, 20, 18);
                        $sheet->setSize('Q' . $intRowNumber, 20, 18);
                    }
                });
            })->download('xlsx');
        }
    }
}