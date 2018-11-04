<?php

namespace App\Http\Controllers\Api;

// use Illuminate\Http\Request;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User as User;
use App\Models\Email as Email;

use Validator, Redirect, Input, Session, Response;


class EmailController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$emails = Email::all();

		return Response::json([
			'emails' => $emails->toArray()
		], 200);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		$view = '';
		return view('backend.admin.emails.create', compact('view'));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$emails = Email::find($id);

		if( ! $emails )
		{
			return Response::json([
				'error' => [
					'message' => 'Delivery day does not exist'
				]
			], 404);
		}

		return Response::json([
			'emails' => $emails->toArray()
		], 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showLatest($userId, $emailId)
	{

		$userEmail   = User::where('id', $userId)->value('email');   
		$emails = Email::where([ ['id', '>', $emailId], ['to', '=', $userEmail], ])->get();

		if( ! $emails )
		{
			return Response::json([
				'error' => [
					'message' => 'Emails does not exist'
				]
			], 404);
		}

		return Response::json([
			'latest_emails' => $emails->toArray()
		], 200);
	}

}
