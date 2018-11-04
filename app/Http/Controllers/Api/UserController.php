<?php

namespace App\Http\Controllers\Api;

// use Illuminate\Http\Request;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User as User;
use App\Models\Email as Email;

use Validator, Redirect, Input, Session, Response, DB;

use Carbon;

class UserController extends Controller
{
    //

    public function index()
	{
		$users = User::all();

		return Response::json([
			'users' => $users->toArray()
		], 200);
	}

	public function count()
	{
		$users_count = User::all()->count();

	    return $users_count;
	}


	public function updateUser(){

		$input = Input::all();

		$id 				= $input["id"];
	    $first_name 		= $input["first_name"];
		$last_name 			= $input["last_name"];
		$email 				= $input["email"];
		$location 			= $input["location"];
		$address 			= $input["address"];
		$delivery_notes 	= $input["delivery_notes"];
		$phone 				= $input["phone"];
		$delivery_day 		= $input["delivery_day"];
		$newsletter 		= $input["newsletter"];


        $update_table = DB::table('users')
			    ->where('id', '=', $input["id"])
			    ->update([
			    	'first_name' 		=> $input["first_name"],
			    	'last_name' 		=> $input["last_name"],
			    	'email' 			=> $input["email"],
			    	'location_id' 		=> $input["location"],
			    	'address' 			=> $input["address"],
			    	'phone' 			=> $input["phone"],
			    	'delivery_notes' 	=> $input["delivery_notes"],
			    	'delivery_day_id' 	=> $input["delivery_day"],
			    	'newsletter' 		=> $input["newsletter"]
			    	]);

		$id = User::where('id', $input["id"])->value('id');

		return Response::json(['status' => 'Success', 'message' => 'Account Updated.', 'id' => $id]);
 	
	}


	public function show($id){

		$user = User::find($id);		

		if( ! $user )
		{
			return Response::json([
				'error' => [
					'message' => 'User does not Exist'
				]
			], 404);
		}

		return Response::json([
			'user' => $user->toArray()
		], 200);
	}


	public function emailsReceived(){

		$userId = Request::segment(4);
		$user = User::where('id', $userId)->first();	
		$userEmail = $user->email;

		$myObject = new Email;

		$emails = Email::where('to', $userEmail)->get();

		$result = array();
		foreach ($emails as $email){

			$from_fname = User::where('email', $email->from)->value('first_name');
		    $from_lname = User::where('email', $email->from)->value('last_name');

		    $to_fname = User::where('email', $email->to)->value('first_name');
		    $to_lname = User::where('email', $email->to)->value('last_name');

			$useremails = 
			
                array(
                	'id' 				=> $email->id,
                	'from' 				=> $email->from,
                	'from_name' 		=> $from_fname." ".$from_lname,
                	'to' 				=> $email->to,
                	'to_name' 			=> $to_fname." ".$to_lname,
                	'cc' 				=> $email->cc,
                	'bcc' 				=> $email->bcc,
                	'subject' 			=> $email->subject,
                	'body' 				=> $email->body,
                	'file_attachment' 	=> $email->file_attachment,
                	'read'				=> $email->read,
                    'active' 			=> $email->active,
                    'created_at' 		=> Carbon\Carbon::parse($email->created_at)->format('d-m-Y H:i:s'),
                	'updated_at' 		=> Carbon\Carbon::parse($email->updated_at)->format('d-m-Y H:i:s'),
                );

		    $result[] = $useremails;

		}

		return Response::json([
			'emails' => $result
		], 200);

  	}

  	public function emailsSent(){

		$userId = Request::segment(4);
		$user = User::where('id', $userId)->first();	

		$userEmail = $user->email; 

		$emails = Email::where('from', $userEmail)->get();

		$result = array();
		foreach ($emails as $email){

			$from_fname = User::where('email', $email->from)->value('first_name');
		    $from_lname = User::where('email', $email->from)->value('last_name');

		    $to_fname = User::where('email', $email->to)->value('first_name');
		    $to_lname = User::where('email', $email->to)->value('last_name');

			$useremails = 
			
                array(
                	'id' 				=> $email->id,
                	'from' 				=> $email->from,
                	'from_name' 		=> $from_fname." ".$from_lname,
                	'to' 				=> $email->to,
                	'to_name' 			=> $to_fname." ".$to_lname,
                	'cc' 				=> $email->cc,
                	'bcc' 				=> $email->bcc,
                	'subject' 			=> $email->subject,
                	'body' 				=> $email->body,
                	'file_attachment' 	=> $email->file_attachment,
                	'read'				=> $email->read,
                    'active' 			=> $email->active,
                    'created_at' 		=> Carbon\Carbon::parse($email->created_at)->format('d-m-Y H:i:s'),
                	'updated_at' 		=> Carbon\Carbon::parse($email->updated_at)->format('d-m-Y H:i:s'),
                );

		    $result[] = $useremails;

		}

		return Response::json([
			'emails' => $result
		], 200);

  	}


  	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromApp($data)
    {
    	/******* Storing Emails from App *******/

    	//[{"from":"10000-00100@posta.co.ke","to":"10000-00100@posta.co.ke","cc":"12000-00100@posta.co.ke","bcc":"",
    	// "subject":"testing 2","body":"hello all testing"}]

    	$json_data = json_decode($data, true);


    	$from = $json_data[0]['from'];
    	$to = $json_data[0]['to'];
    	$cc = $json_data[0]['cc'];
    	$bcc = $json_data[0]['bcc'];

    	// echo utf8_decode(urldecode("Ant%C3%B4nio+Carlos+Jobim"));
    	$subject = utf8_decode(urldecode($json_data[0]['subject']));
    	$body = utf8_decode(urldecode($json_data[0]['body']));


        // store
        $email 				= new \App\Models\Email;
        $email->from       	= $from;
        $email->to    		= $to;
        $email->cc    		= $cc;
        $email->bcc    		= $bcc;
        $email->subject   	= $subject;
        $email->body    	= $body;
        $email->read      	= 0;

        if($email->from == '' && $email->to == ''){
        	return Response::json(['status' => 'Failed', 'message' => 'Email Not Sent.']);
        }else{
	        $email->save();
	        return Response::json(['status' => 'Success', 'message' => 'Email Sent.']);
	    }
        
    }

}
