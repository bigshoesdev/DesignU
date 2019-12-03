<?php

namespace App\Http\Controllers\ShopManager;

use App\HDProductCustomDraw;
use App\HDProductSize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HDProduct;
use App\HDProductCustomDrawOrderDelivery;
use Sentinel;
use Excel;
use App\User;
use App\HDProductCustomDrawOrder;
use App\UserAddress;

class ProjectManageController extends Controller
{
    public function getProjects(Request $req)
    {
        $searchKey = $req->get('searchKey');
        $projects = HDProduct::where('title', 'like', "%$searchKey%")->where('brand_id', Sentinel::getUser()->getBrand()->id)->where('status', 1)->get();

        $data = array();
        $data["projects"] = $projects;
        $data['success'] = true;

        return $data;
    }

    public function copyProject(Request $req)
    {
        $hdProduct = HDProduct::find($req->get('id'));
        $hdProductSizes = $hdProduct->getSizes()->get();
        $hdProductSubImages = $hdProduct->getSubImages();
        $hdProductMainImage = $hdProduct->getMainImage();
        $hdProductDesigns = $hdProduct->getDesigns()->get();
        $hdProductPatterns = $hdProduct->getPatterns()->get();
        $hdProductPrint = $hdProduct->getPrinting()->get();
        $hdProductMappedPatterns = $hdProduct->getMappedPatterns()->get();
        $oldDesignIDsMapping = array();
        $oldDesignImgIDsMapping = array();
        $oldPatternIDsMapping = array();
        $oldPatternImgIDsMapping = array();
        $oldMappedPatternIDsMapping = array();
        $oldSizeIDsMapping = array();

        $newHdProduct = $hdProduct->replicate();
        $newHdProduct->register_date = date('Y-m-d H:i:s');
        $newHdProduct->save();

        $destPath = 'uploads/halfdesign/product/' . $newHdProduct->id . '/';

        if (!\File::exists($destPath)) {
            \File::makeDirectory($destPath);
        }

        foreach ($hdProductSubImages as $hdProductSubImage) {
            $newHdProductSubImage = $hdProductSubImage->replicate();

            $fileName = basename($newHdProductSubImage->url);
            $destFileUrl = "uploads/halfdesign/product/$newHdProduct->id/" . $fileName;
            copy($newHdProductSubImage->url, $destFileUrl);

            $newHdProductSubImage->url = $destFileUrl;
            $newHdProductSubImage->product_id = $newHdProduct->id;
            $newHdProductSubImage->save();
        }

        if ($hdProductMainImage) {
            $newHdProductMainImage = $hdProductMainImage->replicate();

            $fileName = basename($newHdProductMainImage->url);
            $destFileUrl = "uploads/halfdesign/product/$newHdProduct->id/" . $fileName;
            copy($hdProductMainImage->url, $destFileUrl);

            $newHdProductMainImage->url = $destFileUrl;
            $newHdProductMainImage->product_id = $newHdProduct->id;
            $newHdProductMainImage->save();
        }

        foreach ($hdProductSizes as $hdProductSize) {
            $newProductSize = $hdProductSize->replicate();
            $newProductSize->product_id = $newHdProduct->id;
            $newProductSize->save();

            $oldSizeIDsMapping[$hdProductSize->id] = $newProductSize->id;
        }

        foreach ($hdProductDesigns as $hdProductDesign) {
            $newHdProductDesign = $hdProductDesign->replicate();
            $newHdProductDesign->product_id = $newHdProduct->id;
            $newHdProductDesign->save();

            $oldDesignIDsMapping[$hdProductDesign->id] = $newHdProductDesign->id;

            $destPath = 'uploads/halfdesign/design/' . $newHdProductDesign->id . '/';

            if (!\File::exists($destPath)) {
                \File::makeDirectory($destPath);
            }

            $hdProductDesignImgs = $hdProductDesign->getImages()->get();
            foreach ($hdProductDesignImgs as $hdProductDesignImg) {
                $newHdProductDesignImg = $hdProductDesignImg->replicate();

                $fileName = basename($newHdProductDesignImg->url);
                $destFileUrl = "uploads/halfdesign/design/$newHdProductDesign->id/" . $fileName;
                copy($hdProductDesignImg->url, $destFileUrl);

                $newHdProductDesignImg->url = $destFileUrl;
                $newHdProductDesignImg->design_id = $newHdProductDesign->id;
                $newHdProductDesignImg->save();

                $oldDesignImgIDsMapping[$hdProductDesignImg->id] = $newHdProductDesignImg->id;
            }
        }

        foreach ($hdProductPatterns as $hdProductPattern) {
            $newHdProductPattern = $hdProductPattern->replicate();
            $newHdProductPattern->product_id = $newHdProduct->id;
            $newHdProductPattern->save();

            $oldPatternIDsMapping[$hdProductPattern->id] = $newHdProductPattern->id;

            $destPath = 'uploads/halfdesign/pattern/' . $newHdProductPattern->id . '/';

            if (!\File::exists($destPath)) {
                \File::makeDirectory($destPath);
            }

            $hdProductPatternImgs = $hdProductPattern->getImages()->get();

            foreach ($hdProductPatternImgs as $hdProductPatternImg) {
                $newHdProductPatternImg = $hdProductPatternImg->replicate();

                $fileName = basename($newHdProductPatternImg->url);
                $destFileUrl = "uploads/halfdesign/pattern/$newHdProductPattern->id/" . $fileName;
                copy($newHdProductPatternImg->url, $destFileUrl);

                $newHdProductPatternImg->url = $destFileUrl;
                $newHdProductPatternImg->size_id = $oldSizeIDsMapping[$newHdProductPatternImg->size_id];
                $newHdProductPatternImg->pattern_id = $newHdProductPattern->id;
                $newHdProductPatternImg->save();

                $oldPatternImgIDsMapping[$hdProductPatternImg->id] = $newHdProductPatternImg->id;
            }
        }

        foreach ($hdProductMappedPatterns as $hdProductMappedPattern) {
            $newHdProductMappedPattern = $hdProductMappedPattern->replicate();
            $newHdProductMappedPattern->product_id = $newHdProduct->id;
            $newHdProductMappedPattern->pattern_id = $oldPatternIDsMapping[$newHdProductMappedPattern->pattern_id];
            $newHdProductMappedPattern->size_id = $oldSizeIDsMapping[$newHdProductMappedPattern->size_id];
            $newHdProductMappedPattern->save();

            $oldMappedPatternIDsMapping[$hdProductMappedPattern->id] = $newHdProductMappedPattern->id;
        }

        foreach ($hdProductMappedPatterns as $hdProductMappedPattern) {
            $hdProductMappedDesignImgs = $hdProductMappedPattern->getMappedDesignImages()->get();

            foreach ($hdProductMappedDesignImgs as $hdProductMappedDesignImg) {
                $newHdProductMappedDesignImg = $hdProductMappedDesignImg->replicate();
                $newHdProductMappedDesignImg->design_id = $oldDesignIDsMapping[$newHdProductMappedDesignImg->design_id];
                $newHdProductMappedDesignImg->pattern_mapping_id = $oldMappedPatternIDsMapping[$newHdProductMappedDesignImg->pattern_mapping_id];
                $newHdProductMappedDesignImg->design_img_id = $oldDesignImgIDsMapping[$newHdProductMappedDesignImg->design_img_id];
                $newHdProductMappedDesignImg->save();
            }
        }

        if (count($hdProductPrint) > 0) {
            $hdProductPrint = $hdProductPrint[0];
            $newHdProductPrint = $hdProductPrint->replicate();
            $newHdProductPrint->product_id = $newHdProduct->id;
            $newHdProductPrint->size_id = $oldSizeIDsMapping[$newHdProductPrint->size_id];
            $newHdProductPrint->save();

            $hdProductPrintPatterns = $hdProductPrint->getPrintPatterns()->get();

            foreach ($hdProductPrintPatterns as $hdProductPrintPattern) {
                $newHdProductPrintPattern = $hdProductPrintPattern->replicate();
                $newHdProductPrintPattern->print_id = $newHdProductPrint->id;
                $newHdProductPrintPattern->pattern_mapping_id = $oldMappedPatternIDsMapping[$newHdProductPrintPattern->pattern_mapping_id];
                $newHdProductPrintPattern->save();
            }

            $hdProductPrintGroups = $hdProductPrint->getPrintGroups()->get();

            foreach ($hdProductPrintGroups as $hdProductPrintGroup) {
                $newHdProductPrintGroup = $hdProductPrintGroup->replicate();
                $newHdProductPrintGroup->print_id = $newHdProductPrint->id;
                $newHdProductPrintGroup->save();
            }
        }

        return json_encode([
            'success' => true
        ]);
    }

    public function deleteProject(Request $req)
    {
        $project = HDProduct::find($req->get('id'));
        $project->status = 0;
        $project->save();

        return json_encode([
            'success' => true
        ]);
    }

    public function updateProjectState(Request $req)
    {
        $project = HDProduct::find($req->get('id'));
        $state = $req->get('state');
        $project->active = $state;
        $project->save();

        return json_encode([
            'success' => true
        ]);
    }

    public function getProjectItemInfo(Request $req)
    {
        $data = array();
        if ($req->has('projectID')) {
            $projectID = $req->get('projectID');
            $project = HDProduct::find($projectID);
            $data['allOrderCount'] = HDProductCustomDrawOrder::getAllProjectOrderCountByProject($projectID);
            $data['allTotalPrice'] = HDProductCustomDrawOrder::getAllProjectOrderTotalPriceByProject($projectID);
            $data['notDeliveredOrderList'] = HDProductCustomDrawOrder::getNotDeliveredProjectOrderListByProject($projectID);
            $data['endDate'] = $project->date;
            $data['success'] = true;

            return json_encode($data);
        }
    }

    public function getOrderInfo(Request $req)
    {
        $orderID = $req->get('orderID');

        $productOrder = HDProductCustomDrawOrder::find($orderID);
        $customDraw = HDProductCustomDraw::find($productOrder->customdraw_id);
        $user = User::find($productOrder->user_id);

        $data['product'] = HDProduct::find($customDraw->product_id);
        $data['productimg'] = $data['product']->getMainImage();
        $data['size'] = HDProductSize::find($productOrder->product_size);
        $data['totalPrice'] = $data['product']->price;
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

        $projectOrder = HDProductCustomDrawOrder::find($orderID);

        $requestExchangeReturn = $projectOrder->getRequestExchangeReturn();

        $data['projectOrder'] = $projectOrder;
        $data['requestExchangeReturn'] = $requestExchangeReturn;
        $data['success'] = true;

        return json_encode($data);
    }

    public function getProjectItemExchangeReturn(Request $req) {
        if ($req->has('projectID')) {
            $projectID = $req->get('projectID');

            $data = HDProductCustomDrawOrder::getRequestExchangeReturnListByProject($projectID);
            $data['exchangeProjectList'] = $data['exchangeProjectList'];
            $data['returnProjectList'] = $data['returnProjectList'];
            $data['success'] = true;

            return json_encode($data);
        } else
            return json_encode(['success' => false]);
    }

    public function downLoadNotDeliveryList(Request $req)
    {
        $notDeliveredOrderList = array();

        if ($req->has('projectID')) {
            $projectID = $req->get('projectID');
            $notDeliveredOrderList = HDProductCustomDrawOrder::getNotDeliveredProjectOrderListByProject($projectID);

            $data = array();

//            array_push($data, ["ID", "Product Name", "Product Info", "", "", "", "", "", "User Address", "", "", "", "", "", "Delivery Info"]);
            array_push($data, ["ID", "Product Name", "Order Number", "Size", "", "Order Date", "", "Country", "Post Code", "Address", "HP", "Note", "", "Delivery Company", "Delivery No"]);

            foreach ($notDeliveredOrderList as $notDeliveredOrder) {
                $customDraw = HDProductCustomDraw::find($notDeliveredOrder->customdraw_id);
                $productName = HDProduct::find($customDraw->product_id)->title;
                $date = date_format(date_create($notDeliveredOrder->order_date), 'Y-m-d');
                $sizeName = HDProductSize::find($notDeliveredOrder->product_size)->size;

                $item = array();

                array_push($item, $notDeliveredOrder->id, $productName, $notDeliveredOrder->order_no, $sizeName, "", $date, "");
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
                        $sheet->setSize('E' . $intRowNumber, 5, 18);
                        $sheet->setSize('F' . $intRowNumber, 15, 18);
                        $sheet->setSize('G' . $intRowNumber, 5, 18);
                        $sheet->setSize('H' . $intRowNumber, 15, 18);
                        $sheet->setSize('I' . $intRowNumber, 15, 18);
                        $sheet->setSize('J' . $intRowNumber, 20, 18);
                        $sheet->setSize('K' . $intRowNumber, 15, 18);
                        $sheet->setSize('L' . $intRowNumber, 20, 18);
                        $sheet->setSize('M' . $intRowNumber, 5, 18);
                        $sheet->setSize('N' . $intRowNumber, 20, 18);
                        $sheet->setSize('O' . $intRowNumber, 20, 18);
                    }
                });
            })->download('xlsx');
        }
    }

    public function uploadCodingFile(Request $req)
    {
        if ($req->hasFile('excel')) {
            Excel::load($req->file('excel')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $row) {
                    if (!empty($row)) {
                        $orderID = $row['id'];
                        if ($orderID != null) {
                            $hdProductCustomDrawOrder = HDProductCustomDrawOrder::find($orderID);
                            $delivery = $hdProductCustomDrawOrder->getDelivery();
                            $deliveryCompany = $row["delivery_company"];
                            $deliveryNo = $row["delivery_no"];
                            if ($delivery == null && $deliveryNo != "" && $deliveryNo != null && $deliveryCompany != "" && $deliveryCompany != null) {
                                $hdProductCustomOrderDelivery = new HDProductCustomDrawOrderDelivery;
                                $hdProductCustomOrderDelivery->order_id = $orderID;
                                $hdProductCustomOrderDelivery->company = $deliveryCompany;
                                $hdProductCustomOrderDelivery->delivery_no = $deliveryNo;
                                $hdProductCustomOrderDelivery->save();
                                $hdProductCustomDrawOrder->delivered = 1;
                                $hdProductCustomDrawOrder->save();
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

    public function saveReturnRequest(Request $req)
    {
        $orderID = $req->get('orderID');

        $projectOrder = HDProductCustomDrawOrder::find($orderID);

        $requestExchangeReturn = $projectOrder->getRequestExchangeReturn();

        $requestExchangeReturn->is_check = $req->get('complete');
        $requestExchangeReturn->is_agree = $req->get('agree');
        $requestExchangeReturn->client_description = $req->get('description');

        $requestExchangeReturn->save();

        if ($requestExchangeReturn->is_agree > 0) {
            $deliveryCost = $req->get('deliveryCost');

            $chargeMoney = $projectOrder->total_price - $deliveryCost;

            $balance = Sentinel::getUser()->getBalance();
            $balance->amount = $balance->amount + $chargeMoney;
            $balance->save();
//            return json_encode(['success' => false]);
        } else {
            $deliveryCompany = $req->get('deliveryCompany');
            $deliveryNo = $req->get('deliveryNo');

            $delivery = $projectOrder->getDelivery();
            $delivery->company = $deliveryCompany;
            $delivery->delivery_no = $deliveryNo;

            $delivery->save();
        }
        return json_encode(['success' => true]);
    }

    public function saveExchangeRequest(Request $req)
    {
        $orderID = $req->get('orderID');

        $projectOrder = HDProductCustomDrawOrder::find($orderID);

        $requestExchangeReturn = $projectOrder->getRequestExchangeReturn();

        $requestExchangeReturn->is_check = $req->get('complete');
        $requestExchangeReturn->is_agree = $req->get('agree');
        $requestExchangeReturn->client_description = $req->get('description');

        $requestExchangeReturn->save();

        $deliveryCompany = $req->get('deliveryCompany');
        $deliveryNo = $req->get('deliveryNo');

        $delivery = $projectOrder->getDelivery();
        $delivery->company = $deliveryCompany;
        $delivery->delivery_no = $deliveryNo;

        $delivery->save();


        return json_encode(['success' => true]);
    }
}