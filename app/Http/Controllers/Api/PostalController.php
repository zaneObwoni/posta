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

use DB, Response;

class PostalController extends Controller
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
    public function storeFromApp()
    {

        $data = '[{"postal_code":"90305","postal_town":"Kilala","county":"Makueni"},
                    {"postal_code":"90306","postal_town":"Kalamba","county":""},
                    {"postal_code":"90308","postal_town":"Nziu","county":""}]';

    	$json_data = json_decode($data, true);	

        foreach ($json_data as $data) {
            # code...

            // dd($data['postal_town']);

            $postal                 = new Postal;
            $postal->postal_code    = $data['postal_code'];
            $postal->postal_town    = $data['postal_town'];
            $postal->county         = $data['county'];
            $postal->active         = 1;
            $postal->save();
        }

        

        return Response::json(['status' => '1', 'message' => 'Success.']);
    }

    public function box($postCode){

        $matchThese = ['post_code' => $postCode, 'status' => 0];
        $boxes = DB::table('post_boxes')->where($matchThese)->get();

        // dd($boxes);
        foreach($boxes as $box){

            $response['boxes'][] = [
                'postal_code'       => $box->post_code,
                'postal_number'     => $box->number
            ];
        }

        return Response::json($response, 200);
    }
}
