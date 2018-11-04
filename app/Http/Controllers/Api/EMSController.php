<?php

namespace App\Http\Controllers\Api;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Email as Email;
use App\Models\Estamp as Estamp;
use App\Models\Philately as Philately;
use App\Models\Delivery as Delivery;
use App\Models\Postal as Postal;

use App\Models\LetterPrice as LetterPrice;
use App\Models\PrintedPaperPrice as PrintedPaperPrice;
use App\Models\NewspaperPrice as NewspaperPrice;

use App\Models\PacketPrice as PacketPrice;
use App\Models\ParcelBlindPrice as ParcelBlindPrice;

use App\Models\EmsAir as EmsAir;
use App\Models\EmsRoad as EmsRoad;
use App\Models\EmsBagRate as EmsBagRate;
use App\Models\EmsBulkRate as EmsBulkRate;
use App\Models\EmsBahashaKasha as EmsBahashaKasha;
use App\Models\EmsOvernight as EmsOvernight;

use App\Models\Notification as Notification;


use DB, Response;

class EMSController extends Controller
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

        $price       = $json_data[0]['ems_price'];

        // store
        $estamp                     = new Estamp;
        $estamp->sender_phone       = $json_data[0]['sender_phone'];
        $estamp->sender_name        = $json_data[0]['sender_name'];
        $estamp->destination_box    = "1001";
        $estamp->destination_code   = "00100";
        $estamp->recipient_phone    = $json_data[0]['receiver_phone'];
        $estamp->recipient_name     = $json_data[0]['receiver_name'];
        $estamp->origin_town        = $json_data[0]['sender_town'];
        $estamp->destination_town   = $json_data[0]['receiver_town'];

        $estamp->letter_weight      = $json_data[0]['weight'];

        $estamp->price              = $json_data[0]['ems_price'];
    

        $key = \Config::get('app.key');
        $generatedCode = hash_hmac('sha256', str_random(40), $key);

        $estamp->code               = strtoupper($generatedCode);
     
        $estamp->user_id            = $json_data[0]['sender_id'];
        $estamp->active             = 1;
        $estamp->status             = 0;
     
        $estamp->save();


        // store
        $picking = new \App\Models\Picking;

        $picking->building_name     = $json_data[0]['sender_building'];
        $picking->street            = $json_data[0]['sender_street'];
        $picking->town              = $json_data[0]['sender_town'];

        $picking->d_building_name   = $json_data[0]['receiver_building'];
        $picking->d_street          = $json_data[0]['receiver_street'];
        $picking->d_town            = $json_data[0]['receiver_town'];

        $picking->weight            = $json_data[0]['weight'];
        $picking->phone             = $json_data[0]['sender_phone'];
        $picking->fullname          = $json_data[0]['sender_name'];
        $picking->amount            = $json_data[0]['ems_price'];

        $key = \Config::get('app.key');
        $generatedCode = hash_hmac('sha256', str_random(40), $key);

        $picking->code              = "PICKING";
        $picking->stamp_code        = $estamp->code;

        $picking->category          = $json_data[0]['category'];
        $picking->sub_category      = $json_data[0]['ems_type'];
            
        $picking->distance          = 0;
        $picking->extra_weight      = $json_data[0]['weight'];

        $picking->rider_no          = 1;
        $picking->user_id           = $json_data[0]['sender_id'];
        $picking->active            = 0;
        $picking->save();

        // return Response::json(['status' => '1', 'message' => 'EMS Data saved.']);
        return Response::json([
                'status'                => '1',
                'message'               => 'EMS Data saved.',                
                'origin_town'                  => $picking->town,
                'origin-street'         => $picking->street,
                'origin_building'       => $picking->building_name,
                
                'destination_town'      => $picking->d_town,
                'destination_street'    => $picking->d_street,
                'destination_building'  => $picking->d_building_name,

                
                'sender_name'           => $estamp->sender_name,
                'sender_phone'          => $picking->phone,
                'Receiver_name'         => $estamp->recipient_name,
                'Receiver_phone'        => $estamp->recipient_phone,

                'ems_price'             => $picking->amount,
                'category'              => $picking->category,
                'sub_category'          => $picking->sub_category,
                'weight'                => $estamp->letter_weight,
                'stamp_code'            => mb_substr($estamp->code, 0, 10)
                ]);

    }

}
