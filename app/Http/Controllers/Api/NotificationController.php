<?php

namespace App\Http\Controllers\Api;

// use Illuminate\Http\Request;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User as User;
use App\Models\Notification as Notification;

use Validator, Redirect, Input, Session, Response;


class NotificationController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$notifications = Notification::all();

		return Response::json([
			'notifications' => $notifications->toArray()
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
		return view('backend.admin.notifications.create', compact('view'));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$notifications = notification::find($id);

		if( ! $notifications )
		{
			return Response::json([
				'error' => [
					'message' => 'Delivery day does not exist'
				]
			], 404);
		}

		return Response::json([
			'notifications' => $notifications->toArray()
		], 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function userNotifications($phone)
	{
		
		$notifications = notification::where('recipient_phone', $phone)->get();

		if( ! $notifications )
		{
			return Response::json([
				'error' => [
					'message' => 'Notifications does not exist'
				]
			], 404);
		}

		return Response::json([
			'notifications' => $notifications->toArray()
		], 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showLatest($userId, $notificationId)
	{

		$userPhone   = User::where('id', $userId)->value('phone');

		$emails = Notification::where([ ['id', '>', $notificationId], ['recipient_phone', '=', $userPhone], ])->get();

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
