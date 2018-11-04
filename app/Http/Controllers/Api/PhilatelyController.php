<?php

namespace App\Http\Controllers\Api;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Email as Email;
use App\Models\Estamp as Estamp;
use App\Models\Philately as Philately;
use App\Models\Delivery as Delivery;

use DB, Response;

class PhilatelyController extends Controller
{
    //
	public function index(){

		return "index";
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromApp($data)
    {

    

    	$json_data = json_decode($data, true);	

        $userEmail = DB::table('users')->where('id', $json_data[0]['user_id'])->value('email');
        $stampName = DB::table('philately')->where('stamp_name', $json_data[0]['stamp_name'])->value('name');

        $email          = new Email;
        $email->from    = $userEmail;
        $email->to      = "philately@posta.co.ke";
        $email->subject = "Intent to purchase ".$stampName.".";
        $email->body    = "I wish to purchase the philatelic stamp referenced above. Kindly advice on the availability, price and the process of purchasing the above item.";
        $email->save();

        return Response::json(['status' => '1', 'message' => 'Success.']);

    }

}
