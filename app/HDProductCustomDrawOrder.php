<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDProductCustomDrawOrder extends Model
{
    protected $table = 'hd_product_customdraw_order';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function getCustomDraw()
    {
        return HDProductCustomDraw::find($this->customdraw_id);
    }

    public function getDelivery() {
        $delivery = HDProductCustomDrawOrderDelivery::where('order_id', $this->id)->first();

        if (!empty($delivery)) {
            return $delivery;
        } else
            return null;
    }

    public function getRequestExchangeReturn()
    {
        $exchangeReturn = HDProductCustomDrawOrderExchangeReturn::where('order_id', $this->id)->first();

        if (!empty($exchangeReturn)) {
            return $exchangeReturn;
        } else
            return null;
    }

    public static function getRequestExchangeReturnListByProject($productID)
    {
        $paidCustomDraws = HDProductCustomDraw::where('product_id', $productID)->where('is_pay', 1)->get();

        $customDrawIDAry = array();

        foreach ($paidCustomDraws as $customDraw) {
            array_push($customDrawIDAry, $customDraw->id);
        }

        $productOrderList = HDProductCustomDrawOrder::whereIn('customdraw_id', $customDrawIDAry)->where('status', 1)->where('is_request', 1)->get();

        $exchangeProjectList = array();
        $returnProjectList = array();

        foreach ($productOrderList as $productOrder) {
            $exchangeReturn = $productOrder->getRequestExchangeReturn();
            if ($exchangeReturn && $exchangeReturn->is_check == 0) {
                if ($exchangeReturn->type == 'exchange')
                    array_push($exchangeProjectList, $productOrder);
                else
                    array_push($returnProjectList, $productOrder);
            }
        }

        return ['exchangeProjectList' => $exchangeProjectList, 'returnProjectList' => $returnProjectList];
    }


    public static function getAllProjectOrderCountByProject($productID)
    {
        $paidCustomDraws = HDProductCustomDraw::where('product_id', $productID)->where('is_pay', 1)->get();

        $customDrawIDAry = array();

        foreach ($paidCustomDraws as $customDraw) {
            array_push($customDrawIDAry, $customDraw->id);
        }

        $orderList = HDProductCustomDrawOrder::whereIn('customdraw_id', $customDrawIDAry)->where('status', 1)->get();

        return count($orderList);
    }

    public static function getAllProjectOrderTotalPriceByProject($productID)
    {
        $paidCustomDraws = HDProductCustomDraw::where('product_id', $productID)->where('is_pay', 1)->get();

        $customDrawIDAry = array();

        foreach ($paidCustomDraws as $customDraw) {
            array_push($customDrawIDAry, $customDraw->id);
        }

        $totalPrice = HDProductCustomDrawOrder::whereIn('customdraw_id', $customDrawIDAry)->where('status', 1)->sum('total_price');

        return $totalPrice;
    }

    public static function getNotDeliveredProjectOrderListByProject($productID)
    {
        $paidCustomDraws = HDProductCustomDraw::where('product_id', $productID)->where('is_pay', 1)->get();

        $customDrawIDAry = array();

        foreach ($paidCustomDraws as $customDraw) {
            array_push($customDrawIDAry, $customDraw->id);
        }

        $orderList = HDProductCustomDrawOrder::whereIn('customdraw_id', $customDrawIDAry)->where('status', 1)->where('delivered', 0)->get();
        return $orderList;
    }
}
