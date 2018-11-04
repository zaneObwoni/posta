<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use GuzzleHttp\Client;
use App\Models\Notification as Notification;

use App\Models\Payment as Payment;
use App\Models\Estamp as Estamp;

use Pesapal,Input,DB;
use Auth;
use App\Models\User as User;

use Request;

class TransactionController extends Controller
{
    
	public function accountPayment($amount){     
		$txn_id=uniqid();
	    $payments = new Payment;
	    $payments -> order_id = mt_rand(1,10000);
	    $payments -> user_id = Auth::id();
	    $payments -> transaction = $txn_id;
	    $payments -> payment_status = 'Completed';
	    $payments -> amount = $amount;
	    $payments -> save();

	    $details = array(
			'amount' 		=> 600,
	        'reference_id' 	=> 'Personal Virtual Box',
	        'phone' 	=> Auth::user()->phone,
	        'transaction_id' 	=> $txn_id,
	        'callback' 	=> "http://159.203.106.17/sms"
	    );

	    $resp 			= $this->doPOST("http://localhost:10001/c2b/online",$details);
	    $link 			='payment.make';
	    $confirm_link	='success.registration.payment';
	    $user 			= Auth::user();

	    // Comment below this is for Testing - By Lee.
	    // $resp['result']["RETURN_CODE"]= "00";

	    if($resp['result']["RETURN_CODE"] == "00"){
	    	// Add method to check payment status here
	    	
	    	return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link', 'user'));
	    }else{
	    	$confirm_link='payment.make';

	    	return view('backend.success', compact('resp', 'link','confirm_link', 'user'));
	    }
	}

    public function corporateAccountPayment($amount){     
        $txn_id=uniqid();
        $payments = new Payment;
        $payments -> order_id = mt_rand(1,10000);
        $payments -> user_id = Auth::id();
        $payments -> transaction = $txn_id;
        $payments -> payment_status = 'Completed';
        $payments -> amount = $amount;
        $payments -> save();

        $details = array(
            'amount'        => 2000,
            'reference_id'  => 'Corporate Virtual Box',
            'phone'     => Auth::user()->phone,
            'transaction_id'    => $txn_id,
            'callback'  => "http://159.203.106.17/sms"
        );

        $resp           = $this->doPOST("http://localhost:10001/c2b/online",$details);
        $link           ='corporate.payment.make';
        $confirm_link   ='success.registration.payment';
        $user           = Auth::user();

        // Comment below this is for Testing - By Lee.
        // $resp['result']["RETURN_CODE"]= "00";

        if($resp['result']["RETURN_CODE"] == "00"){
            // Add method to check payment status here
            
            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link', 'user'));
        }else{
            $confirm_link='corporate.payment.make';

            return view('backend.corporatesuccess', compact('resp', 'link','confirm_link', 'user'));
        }
    }

	public function paymentConfirmEstamp($txn_id){    
	    $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=".$txn_id);
	    $link="estamps.index";
	    $confirm_link='payment.confirm.estamp';
	    return view('backend.successfulpayment', compact('resp','link', 'confirm_link'));
	}

	public function paymentConfirmEms($txn_id){    
	    $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=".$txn_id);
	    $link="ems.index";
	    $confirm_link='payment.confirm.ems';
	    return view('backend.successfulpayment', compact('resp','link', 'confirm_link'));
	}

	public function paymentConfirmPicking($txn_id){    
	    $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=".$txn_id);
	    $link="pickings.index";
	    $confirm_link='payment.confirm.picking';
	    return view('backend.successfulpayment', compact('resp','link', 'confirm_link'));

	}

	//public function doPOST($url, $data, $txn_id, $amount, $phone)
	// public function doPOST($url, $data)

    public function paymentConfirm($txn_id)
    {

        $link = "user.dashboard";
        $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=" . $txn_id);

        return view('backend.successfulpayment', compact('resp', 'link'));
    }

    //public function doPOST($url, $data, $txn_id, $amount, $phone)
    public function doPOST($url, $data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $resp = array();
        $resp['result'] = json_decode($result, true);
        $resp['data'] = $data;
        return $resp;
    }

    public function doGET($url)
    {
        $curl = curl_init();
		// Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Web App'
        ));
		
		// Send the request & save response to $resp
        $resp = curl_exec($curl);
		
		// Close request to clear up some resources
        curl_close($curl);
        return json_decode($resp, true);
    }


    public function estampPayment($amount)
    {

        $txn_id = uniqid();
        $payments = new Payment;
        $payments->order_id = mt_rand(1, 10000);
        $payments->user_id = Auth::id();
        $payments->transaction = $txn_id;
        $payments->payment_status = 'Completed';
        $payments->amount = $amount;
        $payments->save();
        $details = array(
            'amount' 		=> $payments -> amount,
            'reference_id' => 'Estamp',
            'phone' => Auth::user()->phone,
            'transaction_id' => $txn_id,
            'callback' => "http://159.203.106.17/sms"
        );

        $resp = $this->doPOST("http://localhost:10001/c2b/online", $details);
        $link = 'estamp.payment.make';
        $confirm_link = 'success.estamp.payment';

        $code = Request::segment(5);
        $amount = $payments->amount;

        if ($resp['result']["RETURN_CODE"] == "00") {

            // Estamp::where('id', Auth::id())->update(array('status' => 1));

            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link', 'code', 'amount'));
        } else {
            $link = 'estamp.payment.make';
            $confirm_link = 'success.estamp.payment';

            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link', 'code', 'amount'));


        }
    }

    public function bestwishPayment($amount)
    {

        $txn_id = uniqid();
        $payments = new Payment;
        $payments->order_id = mt_rand(1, 10000);
        $payments->user_id = Auth::id();
        $payments->transaction = $txn_id;
        $payments->payment_status = 'Completed';
        $payments->amount = $amount;
        $payments->save();
        $details = array(
            'amount'      => $payments -> amount,
            'reference_id' => 'Bestwish',
            'phone' => Auth::user()->phone,
            'transaction_id' => $txn_id,
            'callback' => "http://159.203.106.17/sms"
        );

        $resp = $this->doPOST("http://localhost:10001/c2b/online", $details);
        $link = 'bestwish.payment.make';
        $confirm_link = 'success.bestwish.payment';

        $code = Request::segment(5);
        $amount = $payments->amount;

        if ($resp['result']["RETURN_CODE"] == "00") {
            // Estamp::where('id', Auth::id())->update(array('status' => 1));

            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link', 'code', 'amount'));
        } else {
            $link = 'bestwish.payment.make';
            $confirm_link = 'success.bestwish.payment';

            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link', 'code', 'amount'));
        }
    }

    //getundder payment view display
    public function getunderPayments($code)
    {
        // dd($code);

        $user = Auth::user();
        $notifications = Notification::where('recipient_phone', $user->phone)->get();
        $notifications_count = Notification::where('recipient_phone', $user->phone)->count();
        
        return view('backend.underpayments.create', compact('user', 'notifications', 'notifications_count', 'code'));
    }

    //Post underpayments
    public function postunderPayments()
    {
        $stamp_code = Input::get('code');
        $amount=Input::get('amount');
        $user = Auth::user();
        $resp = $this->paybillAllPayments(10);
        $code = $resp['result']["RETURN_CODE"];

        //$trans_id=$resp['result']["TRX_ID"];
        if ($code == '00') {
            $notifications = Notification::where('recipient_phone', $user->phone)->get();
            $notifications_count = Notification::where('recipient_phone', $user->phone)->count();
            return view('backend.underpayments.confirm-payment', compact('user', 'notifications', 'notifications_count', 'resp','stamp_code'));

        } else {
            return redirect()->back();
        }
    }

    //getundder payment view display
    public function underPaymentSuccess()
    {
        if(!empty($_GET['stamp_code']))
        {

            $stamp_code = $_GET['stamp_code'];

            $user = Auth::user();
            $trans_id=$_GET['trans_id'];
            $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=" . $trans_id);
            $payment_status = $resp['data']["TRX_STATUS"];
            if($payment_status=='Success')
            {
                DB::table('underpayments')
                    ->where('stamp_code', $stamp_code)
                    ->update(['active' => 1]);

                $notifications = Notification::where('recipient_phone', $user->phone)->get();
                $notifications_count = Notification::where('recipient_phone', $user->phone)->count();

                return view('backend.underpayments.success', compact('user', 'notifications', 'notifications_count'));
            }
            else
            {
                dd('Your Payment status is '.$payment_status);
            }
            //return view('underpayment.create')
        }
    }

    //Underpayment confirm
    public function postunderPaymentSuccessConfirm()
    {
        $user = Auth::user();
        $notifications = Notification::where('recipient_phone', $user->phone)->get();
        $notifications_count = Notification::where('recipient_phone', $user->phone)->count();
        //dd($user->phone);
        return view('backend.underpayments.success', compact('user', 'notifications', 'notifications_count'));
        //return view('underpayment.create')


    }

    //General payments method Daniel will update it to include all payment details
    public function paybillAllPayments($amount)
    {
        $txn_id = uniqid();
        $payments = new Payment;
        $payments->order_id = mt_rand(1, 10000);
        $payments->user_id = Auth::id();
        $payments->transaction = $txn_id;
        $payments->payment_status = 'Completed';
        $payments->amount = $amount;
        $payments->save();
        $details = array(
            'amount' 		=> $payments -> amount,
            'reference_id' => 'Underpaid',
            'phone' => Auth::user()->phone,
            'transaction_id' => $txn_id,
            'callback' => "http://159.203.106.17/sms"
        );

        $resp = $this->doPOST("http://localhost:10001/c2b/online", $details);

        return $resp;
    }


    public function registeredPayment($amount)
    {

        $txn_id = uniqid();
        $payments = new Payment;
        $payments->order_id = mt_rand(1, 10000);
        $payments->user_id = Auth::id();
        $payments->transaction = $txn_id;
        $payments->payment_status = 'Completed';
        $payments->amount = $amount;
        $payments->save();
        $details = array(
            'amount' 		=> $payments -> amount,
            'reference_id' => 'Registered Mail',
            'phone' => Auth::user()->phone,
            'transaction_id' => $txn_id,
            'callback' => "http://159.203.106.17/sms"
        );

        $resp = $this->doPOST("http://localhost:10001/c2b/online", $details);
        $link = 'registered.payment.make';
        $confirm_link = 'success.registered.payment';

        $code = Request::segment(5);
        $amount = $payments->amount;

        if ($resp['result']["RETURN_CODE"] == "00") {

            // Estamp::where('id', Auth::id())->update(array('status' => 1));

            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link', 'code', 'amount'));
        } else {
            $link = 'registered.payment.make';
            $confirm_link = 'success.registered.payment';

            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link', 'code', 'amount'));


        }
    }

    public function bulkPayment($amount)
    {
        $txn_id = uniqid();
        $payments = new Payment;
        $payments->order_id = mt_rand(1, 10000);
        $payments->user_id = Auth::id();
        $payments->transaction = $txn_id;
        $payments->payment_status = 'Completed';
        $payments->amount = $amount;
        $payments->save();
        $details = array(
            'amount' 		=> $payments -> amount,
            'reference_id' => 'Bulk Estamp Payment',
            'phone' => Auth::user()->phone,
            'transaction_id' => $txn_id,
            'callback' => "http://159.203.106.17/sms"
        );

        $resp = $this->doPOST("http://localhost:10001/c2b/online", $details);

        if ($resp['result']["RETURN_CODE"] == "00") {
            $link = 'bulk.payment.make';
            $confirm_link = 'success.bulk.payment';
            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link'));
        } else {
            $link = 'bulk.payment.make';
            $confirm_link = 'success.bulk.payment';
            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link'));


        }
    }

    public function deliveryPayment($amount)
    {
        $txn_id = uniqid();
        $payments = new Payment;
        $payments->order_id = mt_rand(1, 10000);
        $payments->user_id = Auth::id();
        $payments->transaction = $txn_id;
        $payments->payment_status = 'Completed';
        $payments->amount = $amount;
        $payments->save();
        $details = array(
            'amount' 		=> $payments -> amount,
            'reference_id' => 'Delivery',
            'phone' => Auth::user()->phone,
            'transaction_id' => $txn_id,
            'callback' => "http://159.203.106.17/sms"
        );

        $resp = $this->doPOST("http://localhost:10001/c2b/online", $details);

        if ($resp['result']["RETURN_CODE"] == "00") {
            $link = 'delivery.payment.make';
            $confirm_link = 'success.delivery.payment';
            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link'));
        } else {
            $link = 'delivery.payment.make';
            $confirm_link = 'success.delivery.payment';

            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link'));
        }

    }

    public function pickingPayment($amount)
    {
        $txn_id = uniqid();
        $payments = new Payment;
        $payments->order_id = mt_rand(1, 10000);
        $payments->user_id = Auth::id();
        $payments->transaction = $txn_id;
        $payments->payment_status = 'Completed';
        $payments->amount = $amount;
        $payments->save();
        $details = array(
            // 'amount' 		=> $payments -> amount,
            'amount' => $amount,
            'reference_id' => 'Picking',
            'phone' => Auth::user()->phone,
            'transaction_id' => $txn_id,
            'callback' => "http://159.203.106.17/sms"
        );

        $resp = $this->doPOST("http://localhost:10001/c2b/online", $details);

        if ($resp['result']["RETURN_CODE"] == "00") {
            $link = 'picking.payment.make';
            $confirm_link = 'success.picking.payment';
            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link'));
        } else {
            $link = 'picking.payment.make';
            $confirm_link = 'success.picking.payment';

            return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link'));
        }

    }

    public function confirmation($trackingid, $status, $payment_method, $merchant_reference)
    {
        $payments = Payment::where('tracking', $trackingid)->first();
        $payments->payment_status = $status;
        $payments->payment_method = $payment_method;
        $payments->save();
    }

	public function emsPayment($amount){   

		$txn_id		=uniqid();
	    $payments 	= new Payment;
	    $payments 	-> order_id = mt_rand(1,10000);
	    $payments 	-> user_id = Auth::id();
	    $payments 	-> transaction = $txn_id;
	    $payments 	-> payment_status = 'Completed';
	    $payments 	-> amount = $amount;
	    $payments 	-> save();
	     $details 	= array(
	        'amount' 		=> $payments -> amount,
	        'reference_id' 		=> 'EMS',
	        'phone' 			=> Auth::user()->phone,
	        'transaction_id' 	=> $txn_id,
	        'callback' 			=> "http://159.203.106.17/sms"
	    );

	    $resp = $this->doPOST("http://localhost:10001/c2b/online",$details);
	    $link 				='ems.payment.make'; 
	    $confirm_link		='success.ems.payment';

	    $code = Request::segment(5);
	    $amount = $payments -> amount;

	    if($resp['result']["RETURN_CODE"] == "00"){
	    	Estamp::where('id', Auth::id())->update(array('status' => 1));

	    	return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link', 'code', 'amount'));
	    }else{
	    	$link 			='ems.payment.make'; 
	    	$confirm_link 	='success.ems.payment';

	    	return view('backend.confirm-payment', compact('resp', 'link', 'confirm_link', 'code', 'amount'));
	    }
	}

}
