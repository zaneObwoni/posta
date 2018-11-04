<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\User as User;
use App\Models\Delivery as Delivery;
use App\Models\Notification as Notification;

use App\Models\AgentCollection as AgentCollection;
use App\Models\Invoice as Invoice;

use App\Models\Email as Email;

use Auth, DB, Input, Validator, Session, Request, Redirect;

class AgentCollectionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $agentcollections = AgentCollection::all();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

        return view('backend.agent.collection', compact('user', 'agentcollections', 'notifications', 'notifications_count'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $invoices = Invoice::where('active', 1)->get();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.admin.agentpay.dashboard', compact('user', 'users', 'notifications', 'notifications_count'));
    }

    public function pmAgentCollections()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $agentcollections = AgentCollection::where('postal_code', $user->postcode_id);

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

        return view('backend.agent.collection', compact('user', 'agentcollections', 'notifications', 'notifications_count'));
    }


    public function agents()
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;

        $agents = User::whereHas('roles', function($q)
        {
            $q->where('name', 'Agent');
        })->get();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.admin.agentpay.agents', compact('user', 'users', 'agents', 'notifications', 'notifications_count'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::where('id', $id)->first();
        $mainUser = User::where('id', $id)->first();

        $userId = $user->id;
        $agentName = $user->first_name." ".$user->last_name;

        // $users = User::where('agent_phone', $user->phone)->get();

        $users = User::whereHas('roles', function($q)
        {
            $q->where('name', 'User');
        })->where('agent_phone', $user->phone)->get();

        $corporates = User::whereHas('roles', function($q)
        {
            $q->where('name', 'Corporate');
        })->where('agent_phone', $user->phone)->get();
        // dd($users);

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.admin.agentpay.show', compact('user', 'mainUser', 'users', 'corporates', 'userId', 'agentName', 'notifications', 'notifications_count'));
    }
}