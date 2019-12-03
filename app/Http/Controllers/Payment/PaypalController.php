<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Http\Request;
use App\PayPal;
use Sentinel;

class PaypalController extends Controller{

    public function checkout(Request $req)
    {
        if($req->has('method') && $req->get('method') == 'paypal'){
            $coin = $req->get('coin');

            $paypal = new PayPal;

            $transaction = new Transaction;

            $transaction->method = $req->get('method');
            $transaction->amount =$paypal->formatCoinAmount($coin);
            $transaction->transaction_id = '';
            $transaction->currency = 'USD';
            $transaction->created_by = Sentinel::getUser()->id;
            $transaction->is_success = 0;

            $transaction->save();

            $response = $paypal->purchase([
                'amount' => $transaction->amount ,
                'transactionId' => $transaction->id,
                'currency' => 'USD',
                'cancelUrl' => $paypal->getCancelUrl($order),
                'returnUrl' => $paypal->getReturnUrl($order),
            ]);

            if ($response->isRedirect()) {
                $response->redirect();
            }

            return redirect()->back()->with([
                'message' => $response->getMessage(),
            ]);
        }
    }
}