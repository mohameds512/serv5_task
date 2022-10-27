<?php

namespace App\Http\Controllers;

use App\Models\payment;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use DataTables;

class PaymentController extends Controller
{
    private $gateway;
    public function __construct( )
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }
    public function index()
    {
        return view('payment');
    }

    public function getData( )
    {
        $data = payment::get();
        // return DataTables($data)->addIndexColumn()->make(true);
        // $payments = DataTable::of($data)->addIndexColumn()->make(true);
        // return \response()->json($data);
        // return $data;
        return Datatables::of($data)->addIndexColumn()->make();
    }

    public function charge(Request $request)
    {
        if ($request->input('submit')) {
            try {
                $response = $this->gateway->purchase(array(
                    'amount' =>$request->amount,
                    'currency' =>env('PAYPAL_CURRENCY'),
                    'returnUrl' => url('success'),
                    'cancelUrl' => url('error')
                ));
                $send_trans = $response->send();
                if ($send_trans->isRedirect()) {
                    $send_trans->redirect();
                }else{
                    return $send_trans->getMessage();
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }


    public function success(Request $request)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();
            if ($response->isSuccessful()) {
                $arr_body = $response->getData();

                $payment = new payment();
                $payment->payment_id = $arr_body['id'];
                $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->status =$arr_body['state'];
                $payment->save();

                return ' success Transaction T_ID: '.$arr_body['id'] . '  <a href="http://127.0.0.1:8000/">Home</a> ';
            }
        }else{
            return ' declined';
        }
    }


    public function error( )
    {
        return 'Transaction is canceled';
    }
}
