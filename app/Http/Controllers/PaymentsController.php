<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;


use Input, Auth, Request;

use GuzzleHttp\Client;

use App\Models\User as User;
use App\Models\Payment as Payment;

use App\Models\PaymentStatus as PaymentStatus;
use App\Models\PaymentStatusNew as PaymentStatusNew;

use App\Models\Delivery as Delivery;
use App\Models\Registered as Registered;
use App\Models\Picking as Picking;

use App\Models\Estamp as Estamp;
use App\Models\Bestwish as Bestwish;
use App\Models\Email as Email;
use App\Models\SMS as SMS;

use App\Models\UserPaymentDetail as UserPaymentDetail;
use App\Models\Notification as Notification;

use DB, Response, Redirect;

class PaymentsController extends Controller
{

    public function accountPayment()
    {

        $trans_id = Input::get('trans_id');
        $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=" . $trans_id);
        $userId = Auth::user()->id;
        $status_code = $resp['data']['TRX_STATUS'];

        if ($status_code == 'Success') {
            $userId = Auth::user()->id;
            $user = User::where('id', $userId)->first();

            $recipientPhone = Auth::user()->phone;

            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

            //After show this page with Payment activated.
            $recipientPhone = Auth::user()->phone;
            $recipientFirstName = Auth::user()->first_name;
            $recipientBox = Auth::user()->postbox_id;
            $recipientPost = Auth::user()->postcode_id;
            $recipientTown = Auth::user()->town;
            $recipientEmail = Auth::user()->email;

            User::where('id', $userId)->update(array('active' => 1));

            DB::table('post_boxes')
                ->where('post_code', '=', $user->postcode_id)
                ->where('number', '=', $user->postbox_id)
                ->update(['status' => 1]);

            $to = $recipientPhone;
            $message = 'Registration successful! You have been allocated P.O. Box No. ' . $recipientBox . '-' . $recipientPost . ', ' . $recipientTown . '. Your email address at posta is ' . $recipientEmail . ".";

            $emailMessage = "Welcome to Posta and thank you for acquiring your own P.O. Box! To login, you must use your email " . $recipientEmail . ". Your password is the one you used at registration. Attached here with is your certificate of ownership which expires every year and it is renewed everytime you renew your subscription.";

            $email = new Email;
            $email->from = "noreply@posta.co.ke";
            $email->to = $recipientEmail;
            $email->file_attachment = "PCK-".$userId.".pdf";
            $email->subject = "Welcome to Posta";
            $email->body = $emailMessage;
            $email->save();

            UserController::createCertificate();

            $notify = new SendSMSController();
            $notify->sendSms($to, $message);


            return view('backend.payment.registration', compact('user', 'estamp', 'notifications', 'notifications_count'));
        } else {
            //return redirect->back()->withErrors('message', 'Please try again');
            return Redirect::back()->withErrors(['Payments not confirmed! Please try again']);
        }
    }


    public function estampPaymentSuccess()
    {

        $trackingid = Input::get('tracking_id');
        $ref = Input::get('merchant_reference');
        $payments = Payment::where('transaction', $ref)->first();
        $payments->tracking = $trackingid;
        $payments->save();


        $user_payments = new UserPaymentDetail;
        $user_payments->amount = $payments->amount;
        $user_payments->description = 'Payment';
        $user_payments->type = 'MERCHANT';
        $user_payments->first_name = Auth::user()->first_name;
        $user_payments->last_name = Auth::user()->last_name;
        $user_payments->email = Auth::user()->email;
        $user_payments->phonenumber = Auth::user()->phone;
        $user_payments->reference = $ref;
        $user_payments->method = 'Mobile Money';
        // $user_payments->code 		= $payment_code,
        $user_payments->status = $payments->payment_status;
        $user_payments->save();
        //'currency' => 'USD'

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        Estamp::where('id', Auth::id())->update(array('status' => 1));

        return view('backend.registration-payment', ['trackingid' => $trackingid, 'ref' => $ref, 'notifications' => $notifications, 'notifications_count' => $notifications_count, 'user' => Auth::user()]);
    }


    public function smsCallback()
    {

        $input = Input::all();

        $file = getcwd() . '/people.txt';
        // Open the file to get existing content
        $current = file_get_contents($file);

        // Append a new person to the file --- $email      = $input["email"];
        $current = $input;
        // Write the contents back to the file
        file_put_contents($file, $current);

        $amount = $input['AMOUNT'];
        $description = $input['DESCRIPTION'];
        $enc_params = $input['ENC_PARAMS'];
        $merchant_transaction_id = $input['MERCHANT_TRANSACTION_ID'];
        $mpesa_trx_date = $input['MPESA_TRX_DATE'];
        $mpesa_trx_id = $input['MPESA_TRX_ID'];
        $msisdn = $input['MSISDN'];
        $return_code = $input['RETURN_CODE'];
        $trx_id = $input['TRX_ID'];
        $trx_status = $input['TRX_STATUS'];


        $payment = new PaymentStatus;
        $payment->amount = $amount;
        $payment->description = $description;
        $payment->enc_params = $enc_params;
        $payment->merchant_transaction_id = $merchant_transaction_id;
        $payment->mpesa_trx_date = $mpesa_trx_date;
        $payment->mpesa_trx_id = $mpesa_trx_id;
        $payment->msisdn = $msisdn;
        $payment->return_code = $return_code;
        $payment->trx_id = $trx_id;
        $payment->trx_status = $trx_status;

        $payment->save();
    }

    public function smsCallbackV2()
    {

        $input = Input::all();

        //Getting data from VPN Realtime

        $amount = $input['AMOUNT'];
        $description = $input['DESCRIPTION'];
        $enc_params = $input['ENC_PARAMS'];
        $merchant_transaction_id = $input['MERCHANT_TRANSACTION_ID'];
        $mpesa_trx_date = $input['MPESA_TRX_DATE'];
        $mpesa_trx_id = $input['MPESA_TRX_ID'];
        $msisdn = $input['MSISDN'];
        $return_code = $input['RETURN_CODE'];
        $trx_id = $input['TRX_ID'];
        $trx_status = $input['TRX_STATUS'];


        $payment = new PaymentStatusNew;
        $payment->amount = $amount;
        $payment->description = $description;
        $payment->enc_params = $enc_params;
        $payment->merchant_transaction_id = $merchant_transaction_id;
        $payment->mpesa_trx_date = $mpesa_trx_date;
        $payment->mpesa_trx_id = $mpesa_trx_id;
        $payment->msisdn = $msisdn;
        $payment->return_code = $return_code;
        $payment->trx_id = $trx_id;
        $payment->trx_status = $trx_status;

        $payment->save();
    }

    public function callbackMobile($data)
    {

        $callBackData = new One;
        $callBackData->one = $data;
        $callBackData->save();

    }

    public function mobilePayment($code)
    {

        $payment_data = DB::table('payment_status')->where('merchant_transaction_id', $code)->first();

        // dd($payment_data->trx_status);

        $trx_id_array = DB::table('payment_status')->pluck('merchant_transaction_id');

        if (in_array($code, $trx_id_array)) {

            if ($payment_data->trx_status == 'Success') {


                return Response::json(['status' => '1', 'message' => 'User has Paid.']);

            } else {
                return Response::json(['status' => '0', 'message' => 'User has not Paid.']);
            }

        } else {

            // echo "False";
            return Response::json(['status' => '0', 'message' => 'Code not Found.']);
        }
    }

    public function mpesaPayment()
    {

        $client = new Client;

        $response = $client->request('POST', 'http://test.cinchltd.com:10001/c2b/online', [
            'form_params' => [
                'transaction_id' => 'abc',
                'reference_id' => '123',
                'amount' => '10',
                'phone' => '0710775577',
                'callback' => 'http://www.enjiwa.com/sms/v2'
            ]
        ]);


        if ($response->getStatusCode() == 200) {
            echo 'True';
        } else {
            echo 'False';
        }

    }


    public function paybill_payment()
    {

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'http://test.cinchltd.com:10001/c2b/online', [
            'form_params' => [
                'transaction_id' => '1#do32',
                'reference_id' => 'Account',
                'amount' => '10',
                'phone' => '0710775577',
                'callback' => 'http://www.enjiwa.com/sms/v2'
            ]
        ]);
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


    public function stampPayment()
    {

        $trans_id = Input::get('trans_id');
        $code = Input::get('code');

        $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=" . $trans_id);

        $status_code = $resp['data']['TRX_STATUS'];

        if ($status_code == 'Success') {

            $userId = Auth::user()->id;
            $user = User::where('id', $userId)->first();

            $recipientPhone = Auth::user()->phone;

            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

            $code = Estamp::where('id', $code)->value('code');

            Estamp::where('code', $code)->update(array('status' => 1));

            $category = Estamp::where('code', $code)->value('category');

            return view('backend.payment.stamp', compact('user', 'estamp', 'notifications', 'notifications_count', 'category'));
        } else {
            return Redirect::back()->withErrors(['Please try again']);
        }
    }

    public function bestwishPayment()
    {

        $trans_id = Input::get('trans_id');
        $code = Input::get('code');

        $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=" . $trans_id);

        $status_code = $resp['data']['TRX_STATUS'];

        if ($status_code == 'Success') {

            $userId = Auth::user()->id;
            $user = User::where('id', $userId)->first();

            $recipientPhone = Auth::user()->phone;

            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
            if (strlen($code) > 15) {
                Bestwish::where('batch_number', $code)->update(array('status' => 1));

            } else {
                Bestwish::where('code', $code)->update(array('status' => 1));
            }
            // $category = Estamp::where('code', $code)->value('category');

            return view('backend.payment.bestwish', compact('user', 'estamp', 'notifications', 'notifications_count'));
        } else {
            return Redirect::back()->withErrors(['Please try again']);
        }
    }

    public function registeredPayment()
    {

        $trans_id = Input::get('trans_id');
        $code = Input::get('code');

        $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=" . $trans_id);

        $status_code = $resp['data']['TRX_STATUS'];

        if ($status_code == 'Success') {

            // dd($status_code);

            $userId = Auth::user()->id;
            $user = User::where('id', $userId)->first();

            $recipientPhone = Auth::user()->phone;

            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

            // Registered::where('code', $code)->update(array('status' => 1));

            // $category = Registered::where('code', $code)->value('category');

            return view('backend.payment.registered', compact('user', 'estamp', 'notifications', 'notifications_count'));
        } else {
            return Redirect::back()->withErrors(['Please try again']);
        }
    }

    public function deliveryPayment()
    {
        $trans_id = Input::get('trans_id');
        $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=" . $trans_id);

        $status_code = $resp['data']['TRX_STATUS'];
        if ($status_code == 'Success') {

            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;

            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

            $receiver_phone       = Auth::user()->phone;            
            $delivery = Delivery::where('phone', $receiver_phone)->orderBy('created_at', 'desc')->first();

            $receiver_name        = Auth::user()->first_name." ".Auth::user()->last_name;
            $receiver_email       = Auth::user()->email;
            $message = "Dear ".$receiver_name.", Your request for Delivery of your item No. ".$delivery->stamp_code." has been received and is being processed. We shall inform you when it leaves our depot. Thank you";

            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = $receiver_email;
            $email->subject = "Delivery Options";
            $email->body    = $message;
            $email->save();

            $sms                = new SMS;
            $sms->to            = "receiver";
            $sms->subject       = "DELIVERY LETTER";
            $sms->message       = $message;
            $sms->phone         = $receiver_phone;
            $sms->status        = "PROGRESS";
            $sms->active        = 1;
            $sms->save();
            
            $notify = new SendSMSController();
            $notify->sendSms($receiver_phone, $message);

            return view('backend.payment.delivery', compact('user', 'estamp', 'notifications', 'notifications_count'));
        } else {
            return Redirect::back()->withErrors(['Please try again']);
        }
    }

    public function pickingPayment()
    {

        $trans_id = Input::get('trans_id');
        $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=" . $trans_id);



        $status_code = $resp['data']['TRX_STATUS'];
        if ($status_code == 'Success') {
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;

            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

            //Send SMS and Email to User
            $receiver_phone       = Auth::user()->phone;
            $receiver_name        = Auth::user()->first_name." ".Auth::user()->last_name;
            $receiver_email       = Auth::user()->email;

            $message = "Dear ".$receiver_name.", your picking request has been received and is being processed. We shall inform you when a rider/driver is on their way to you. Thank you.";

            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = $receiver_email;
            $email->subject = "Picking Options";
            $email->body    = $message;
            $email->save();

            $sms                = new SMS;
            $sms->to            = "receiver";
            $sms->subject       = "PICKING LETTER";
            $sms->message       = $message;
            $sms->phone         = $receiver_phone;
            $sms->status        = "PROGRESS";
            $sms->active        = 1;
            $sms->save();

            $notify = new SendSMSController();
            $notify->sendSms($receiver_phone, $message); 

            return view('backend.payment.picking', compact('user', 'estamp', 'notifications', 'notifications_count'));
        } else {
            return Redirect::back()->withErrors(['Please try again']);

        }
    }

    public function registeredMailPayment()
    {
        $trans_id = Input::get('trans_id');
        $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=" . $trans_id);

        $status_code = $resp['data']['TRX_STATUS'];

        if ($status_code == 'Success') {

            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;

            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

            return view('backend.payment.registered', compact('user', 'estamp', 'notifications', 'notifications_count'));
        }
        {
            return Redirect::back()->withErrors(['Please try again']);
        }
    }

    public function bulkMailPayment()
    {
        $trans_id = Input::get('trans_id');
        $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=" . $trans_id);

        $status_code = $resp['data']['TRX_STATUS'];
        if ($status_code =='Success') {

            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;

            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

            return view('backend.payment.bulk', compact('user', 'estamp', 'notifications', 'notifications_count'));
        } else {
            return Redirect::back()->withErrors(['Please try again']);
        }
    }

    public function emsPayment()
    {
        $trans_id = Input::get('trans_id');
        $resp = $this->doGET("http://localhost:10001/c2b/online?transaction_id=" . $trans_id);

        $status_code = $resp['data']['TRX_STATUS'];
        if ($status_code == 'Success') {

            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;

            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

            return view('backend.payment.ems', compact('user', 'estamp', 'notifications', 'notifications_count'));
        } else {
            return Redirect::back()->withErrors(['Please try again']);
        }
    }
}
