<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use \AfricasTalkingGateway;

use Response;

class SendSMSController extends Controller
{
    //

    public function sendSms($to, $message){

				
    	// Sending premium rated messages
		$username   = "leeibrah";
		$apikey     = "e0b2d204106da2a17a59ebbf26ca6df3da2f7422770bfdd5a093f8ba92e5d111";
		$recipient = $to;

		$message = $message;
		// Specify your premium shortCode and keyword
		$from = "POSTA";
		$gateway    = new AfricasTalkingGateway($username, $apikey);
		
		try
		{
		   
		   $results = $gateway->sendMessage($recipient, $message, $from);
		            
		  foreach($results as $result) {
		    echo " Number: " .$result->number;
		    echo " Status: " .$result->status;
		    echo " MessageId: " .$result->messageId;
		    echo " Cost: "   .$result->cost."\n";
		  }
		}
		catch ( AfricasTalkingGatewayException $e )
		{
		  echo "Encountered an error while sending: ".$e->getMessage();
		}

    }

}
