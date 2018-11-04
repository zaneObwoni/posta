<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/







/*
|--------------------------------------------------------------------------
| The API
|--------------------------------------------------------------------------
*/


Route::group(array('prefix' => 'api/v1'), function () {

    /*
    |--------------------------------------------------------------------------
    | The API  - Login
    |--------------------------------------------------------------------------
    */

    Route::post('/signin', function () {

        $input = Input::all();
        return Redirect::to('/signin?email=' . $input["email"] . '&password=' . $input["password"]);
    });

    Route::post('/signin', 'Api\AuthController@postLogin');

    Route::post('/staff/signin', function () {

        $input = Input::all();
        return Redirect::to('/signin?id_no=' . $input["id_no"] . '&employee_no=' . $input["employee_no"]);
    });

    Route::post('/staff/signin', 'Api\AuthController@deliveryOfficerLogin');


    /*
    |--------------------------------------------------------------------------
    | The API  - Register
    |--------------------------------------------------------------------------
    */
    Route::post('/register', function () {

        $input = Input::all();

        return Redirect::to('/api/register?first_name=' . $input["first_name"] .
            '&last_name=' . $input["last_name"] .
            '&email=' . $input["email"] .
            '&password=' . $input["password"] .
            '&confirm_password=' . $input["confirm_password"] .
            '&phone=' . $input["phone"] .

            '&gender=' . $input["gender"] .
            '&date_of_birth=' . $input["date_of_birth"] .
            '&occupation=' . $input["occupation"] .

            '&town=' . $input["town"] .
            '&county_id=' . $input["county_id"] .
            '&identification_number=' . $input["identification_number"] .
            '&pin=' . $input["pin"] .
            '&postcode_id=' . $input["postcode_id"] .
            '&postbox_id=' . $input["postbox_id"] .
            '&current_email=' . $input["current_email"]
        );
        // first_name=Eric&last_name=Mungai&current_email=karomomungai@gmail.com&phone=0720764321&identification_number=25935262
        // &password=karomo&confirm_password=karomo&gender=Male&date_of_birth=03/17/16&occupation=Mobile Developer&pin=ra45
        // &postcode_id=00200&postbox_id=00500&town=Sarit Centre&county_id=29
    });

    Route::post('/register', 'Api\AuthController@postRegister');





    /*
    |--------------------------------------------------------------------------
    | The API  - User Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', function () {
        $current_user = Auth::user();
        $user_id = Auth::user()->id;

        $user = DB::table('users')->where('id', $user_id);

        $user = array(
            'id' => $current_user->id,
            'first_name' => $current_user->first_name,
            'last_name' => $current_user->last_name,
            'postcode_id' => $current_user->postcode_id,
            'postbox_id' => $current_user->postbox_id,
            'email' => $current_user->email,
            'phone' => $current_user->phone
        );
        // var_dump($user_id);
        return Response::json(['profile' => $user]);
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'Api\UserController@index');

        Route::get('/{id}', 'Api\UserController@show');


        Route::get('/{id}/emails/received', 'Api\UserController@emailsReceived');
        Route::get('/{id}/emails/sent', 'Api\UserController@emailsSent');

        Route::get('/{phone}/notifications', 'Api\NotificationController@userNotifications');
        
    });


    Route::group(['prefix' => 'postcodes'], function () {
        
        Route::get('/{postCode}', 'Api\PostalController@box');
    });
    

    Route::group(['prefix' => 'emails'], function () {

        Route::get('/', 'Api\EmailController@index');
        Route::post('create/{data}', 'Api\UserController@storeFromApp');

        Route::get('/{userId}/{emailId}', 'Api\EmailController@showLatest');

    });

    Route::group(['prefix' => 'notifications'], function () {
        
        Route::get('/{userId}/{emailId}', 'Api\NotificationController@showLatest');

    });

    Route::post('/transaction/{code}', 'PaymentsController@mobilePayment');

    Route::group(['prefix' => 'stamp'], function () {

        //Stamp
        Route::get('/', 'Api\StampController@index');

        Route::get('user/{id}', 'Api\StampController@userStamps');
        Route::post('create/{data}', 'Api\StampController@storeFromApp');

    });

    Route::group(['prefix' => 'bestwishes'], function () {

        Route::post('create/{data}', 'Api\StampController@storeBestWishesFromApp');
    });

    Route::group(['prefix' => 'delivery'], function () {

        //Stamp
        Route::get('/', 'Api\DeliveryController@index');

        Route::post('create/{data}', 'Api\DeliveryController@storeFromApp');

    });

    Route::group(['prefix' => 'picking'], function () {

        //Stamp
        Route::get('/', 'Api\PickingController@index');

        Route::post('create/{data}', 'Api\PickingController@storeFromApp');

    });

    Route::group(['prefix' => 'rts'], function () {

        //Stamp
        Route::get('/', 'NotificationController@rts');

        Route::post('create/{data}', 'NotificationController@rts');
        Route::post('parcel/create/{data}', 'NotificationParcelController@rts');

        Route::post('pay/{data}', 'Api\RTSController@pay');

    });

    Route::group(['prefix' => 'agents'], function () {
        // Route::get('/', 'NotificationController@index');

        // Route::get('create/{data}', 'NotificationController@agents');
        Route::post('create/{data}', 'NotificationController@agents');

    });

    Route::group(['prefix' => 'underpayment'], function () {
        // Route::get('/', 'NotificationController@index');

        Route::get('create/{data}', 'NotificationController@under');
        Route::post('parcel/create/{data}', 'NotificationParcelController@under');

    });

    Route::group(['prefix' => 'philately'], function () {
        // Route::get('/', 'NotificationController@index');

        Route::post('create/{data}', 'Api\PhilatelyController@storeFromApp');

    });

    Route::group(['prefix' => 'postals'], function () {
        // Route::get('/', 'NotificationController@index');

        Route::get('create/', 'Api\PostalController@storeFromApp');

    });

    Route::group(['prefix' => 'ems'], function () {

        Route::post('create/{data}', 'Api\EMSController@storeFromApp');
    });

    Route::group(['prefix' => 'reports'], function () {

        Route::get('/', 'Api\ReportController@index');
        Route::get('/branch/{postcode}', 'Api\ReportController@branchManager');
    });
});






/*
|--------------------------------------------------------------------------
| The Web Middleware
|--------------------------------------------------------------------------
*/
//Route::group(['middleware' => ['web']], function () {

Route::get('/', 'FrontendController@index')->name('home');

//testing environment... ;)
Route::get('environment', function () {
    if (App::environment('local', 'staging')) {
        echo 'Yo dawg, the environment is ' . App::environment();
    } else {
        echo 'We are on ' . App::environment();
    }
});

//run tests ...
Route::get('tests', function () {

    return ucwords($_SERVER['SERVER_NAME']);
});


$a = 'auth.';

Route::get('/agent/login', ['as' => $a . 'agent-login', 'uses' => 'Auth\AuthController@getAgentLogin']);
Route::post('agent/login', ['as' => $a . 'login-agent-post', 'uses' => 'Auth\AuthController@postAgentLogin']);

Route::get('/login', ['as' => $a . 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('/login', ['as' => $a . 'login-post', 'uses' => 'Auth\AuthController@postLogin']);


Route::get('/registerall', ['as' => $a . 'registerall', 'uses' => 'Auth\AuthController@getregisterall']);
Route::get('/password', ['as' => $a . 'password', 'uses' => 'Auth\AuthController@getPassword']);
Route::post('/password', ['as' => $a . 'password', 'uses' => 'Auth\AuthController@password']);


Route::get('/password-reset', ['as' => $a . 'reset', 'uses' => 'Auth\AuthController@getPasswordReset']);
Route::post('/password-reset', ['as' => $a . 'reset-post', 'uses' => 'Auth\AuthController@passwordReset']);
Route::get('/reset/success', ['as' => 'reset.success', 'uses' => 'Auth\AuthController@resetSuccess']);


Route::get('/register',         ['as' => $a . 'register',       'uses' => 'Auth\AuthController@getRegister']);
Route::post('/register',        ['as' => $a . 'register-post', 'uses' => 'Auth\AuthController@postRegister']);

Route::get('/register', ['as' => $a . 'register', 'uses' => 'Auth\AuthController@getRegister']);
Route::get('/createcontact', ['as' => $a . 'create-contact', 'uses' => 'Auth\AuthController@getCreateContact']);
Route::post('/createcontact', ['as' => $a . 'create-contact', 'uses' => 'Auth\AuthController@postCreateContact']);

Route::post('/staff/register', ['as' => $a . 'register-staff', 'uses' => 'Auth\AuthController@postRegisterstaff']);
Route::post('/staff/edit', ['as' => $a . 'edit-staff', 'uses' => 'Auth\AuthController@postEditstaff']);
Route::get('/corporate', ['as' => $a . 'corporate', 'uses' => 'Auth\AuthController@getCorporate']);
Route::post('/corporate', ['as' => $a . 'corporate-post', 'uses' => 'Auth\AuthController@postCorporate']);

Route::get('register_postcode/{code}/postboxes.json', function ($code) {

    return (DB::table('post_boxes')->where('post_code', $code)->where('status', 0)->get());
});
Route::get('user/deliveries/register_postcode/{code}/postboxes.json', function ($code) {
    if($code==1)
    {
        return (DB::table('ems_bahasha_kasha')->get());
    }
    if($code==2)
    {
        return (DB::table('ems_overnight')->get());
    }
    if($code==3)
    {
        return (DB::table('ems_bag_rate')->get());
    }
    if($code==4)
    {
        return (DB::table('ems_bulk_rate')->get());
    }
    if($code==5)
    {
        return (DB::table('ems_road')->get());
    }
    if($code==6)
    {
        return (DB::table('ems_air')->get());
    }
});
//User pickings route
Route::get('user/pickings/register_postcode/{code}/postboxes.json', function ($code) {
    //dd($code.'New code');
    if($code==1)
    {
        return (DB::table('ems_bahasha_kasha')->get());
    }
    if($code==2)
    {
        return (DB::table('ems_overnight')->get());
    }
    if($code==3)
    {
        return (DB::table('	ems_bag_rate')->get());
    }
    if($code==4)
    {
        return (DB::table('ems_bulk_rate')->get());
    }
    if($code==5)
    {
        return (DB::table('ems_road')->get());
    }
    if($code==6)
    {
        return (DB::table('ems_air')->get());
    }
});

//EMS Deliveries
Route::get('user/estamps/register_postcode/{code}/postboxes.json', function ($code) {
    //dd($code.'New code');
    if($code==1)
    {
        return (DB::table('ems_bahasha_kasha')->get());
    }
    if($code==2)
    {
        return (DB::table('ems_overnight')->get());
    }
    if($code==3)
    {
        return (DB::table('	ems_bag_rate')->get());
    }
    if($code==4)
    {
        return (DB::table('ems_bulk_rate')->get());
    }
    if($code==5)
    {
        return (DB::table('ems_road')->get());
    }
    if($code==6)
    {
        return (DB::table('ems_air')->get());
    }
});

//EMS Services
Route::get('user/estamps/ems/register_postcode/{code}/postboxes.json', function ($code) {

    if($code==1)
    {
        return (DB::table('ems_bahasha_kasha')->get());
    }
    if($code==2)
    {
        return (DB::table('ems_overnight')->get());
    }
    if($code==3)
    {
        return (DB::table('	ems_bag_rate')->get());
    }
    if($code==4)
    {
        return (DB::table('ems_bulk_rate')->get());
    }
    if($code==5)
    {
        return (DB::table('ems_road')->get());
    }
    if($code==6)
    {
        return (DB::table('ems_air')->get());
    }
});


Route::get('staff_rider/{code}/postboxes.json', function ($code) {
    //dd($code.'New code');

    return (DB::table('staffs')->where('means', $code)->where('status', 0)->get());
});


// Password Reset
Route::controllers([
    'password' => 'Auth\PasswordController',
]);

Route::get('test', function () {

    return view('backend.admin.test');
});

Route::get('logout', function () {
    Auth::logout();
    return redirect()->route('home');
});


// Route::get('registration/success', 'FrontendController@success')->name('registration.success');

Route::get('/success', array('as' => 'success', 'uses' => 'UserController@success'));
Route::get('/corporate/success', array('as' => 'corporatesuccess', 'uses' => 'UserController@corporateSuccess'));
//PhpMail test
Route::get('/mail', array('as' => 'mail', 'uses' => 'UserController@phpMail'));
//Box generate using user controller
Route::get('/box_generate', array('as' => 'box_generate', 'uses' => 'UserController@getPostcode'));
Route::post('/addPostcode', array('as' => 'addPostcode', 'uses' => 'UserController@addPostcode'));

Route::get('/coming-soon', array('as' => 'coming', 'uses' => 'FrontendController@coming'));

Route::group(['prefix' => 'physical'], function ()
{
    $p = 'physical.';

    Route::get('choose', array('as' => $p . 'choose', 'uses' => 'Auth\AuthController@choose'));

    Route::get('user/register',         ['as' => $p . 'register',       'uses' => 'Auth\AuthController@getPhysicalUserRegister']);
    Route::post('user/register',        ['as' => $p . 'register-post', 'uses' => 'Auth\AuthController@postPhysicalUserRegister']);

    Route::get('corporate/register',         ['as' => $p . 'corporate.register',       'uses' => 'Auth\AuthController@getPhysicalCorporateRegister']);
    Route::post('corporate/register',        ['as' => $p . 'corporate.register-post', 'uses' => 'Auth\AuthController@postPhysicalCorporateRegister']);
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'middleware' => 'auth'], function () // Route::group(['prefix' => 'admin'], function()
{
    $a = 'admin.';
    Route::get('dashboard', array('as' => $a . 'dashboard', 'uses' => 'Admin\AdminController@dashboard'));
    Route::get('dashboard/{startDate}/{endDate}', array('as' => $a . 'dashboard-range', 'uses' => 'Admin\AdminController@dashboardRange'));
    //Brach manager dashboard
    Route::get('branchmanager', array('as' => $a . 'branchmanager', 'uses' => 'UserController@managerDashboard'));

    
    Route::get('corporates', array('as' => $a . 'corporates', 'uses' => 'Admin\AdminController@corporates'));
    Route::get('physical/boxes', array('as' => $a . 'physical', 'uses' => 'Admin\AdminController@physicalBoxes'));

    // Delivery
    Route::get('deliveries', array('as' => $a . 'deliveries', 'uses' => 'Admin\AdminController@deliveries'));
    Route::get('deliveries/{deliveriesId}/edit', array('as' => $a . 'deliveries.edit', 'uses' => 'Admin\AdminController@editDelivery'));

    Route::post('deliveries/{deliveriesId}/update', array('as' => $a . 'deliveries.update', 'uses' => 'Admin\AdminController@updateRiderDelivery'));
    Route::get('deliveries/{deliveriesId}', array('as' => $a . 'deliveries.show', 'uses' => 'Admin\AdminController@showRiderCode'));

    Route::get('deliveries/{deliveriesId}/sign/', array('as' => $a . 'deliveries.sign_form', 'uses' => 'Admin\AdminController@showDeliveryForm'));    

    // Picking
    Route::get('pickings', array('as' => $a . 'pickings', 'uses' => 'Admin\AdminController@pickings'));
    Route::get('pickings/{pickingId}/edit', array('as' => $a . 'pickings.edit', 'uses' => 'Admin\AdminController@editPicking'));

    Route::post('pickings/{pickingId}/update', array('as' => $a . 'pickings.update', 'uses' => 'Admin\AdminController@updateRiderPicking'));
    Route::get('pickings/{pickingId}', array('as' => $a . 'pickings.show', 'uses' => 'Admin\AdminController@showRiderCode'));

    Route::get('pickings/{pickingId}/sign/', array('as' => $a . 'pickings.sign_form', 'uses' => 'Admin\AdminController@showPickingForm'));    

    //Main Picking Registered    
    Route::get('main/pickings/create', array('as' => $a . 'main.pickings.create', 'uses' => 'Admin\AdminController@mainPickingCreate'));
    Route::post('main/pickings/create', array('as' => $a . 'store', 'uses' => 'Admin\AdminController@mainPickingStore'));
    // Route::get('main/pickings/{pickingId}/edit', array('as' => $a . 'pickings.edit', 'uses' => 'Admin\AdminController@editPicking'));

    Route::post('main/pickings', array('as' => $a . 'mail.store', 'uses' => 'Admin\AdminController@getPickingCode'));
    Route::get('main/pickings/update/{code}', array('as' => $a . 'main.update', 'uses' => 'Admin\AdminController@updateTable'));

    Route::get('updated/picking', array('as' => $a . 'main.picking.success', 'uses' => 'Admin\AdminController@picked'));

    //Staffs route
    Route::get('staffs', array('as' => $a . 'staffs', 'uses' => 'Admin\AdminController@staffs'));
    Route::get('allstaffshow', array('as' => $a . 'allstaffshow', 'uses' => 'Admin\AdminController@allstaffshow'));

    Route::get('drivers', array('as' => $a . 'drivers', 'uses' => 'Admin\AdminController@drivers'));
    Route::get('allstaffs', array('as' => $a . 'allstaff', 'uses' => 'Admin\AdminController@allstaffs'));
    
    //Add a new staff route
    Route::get('staffs/createstaff', array('as' => $a . 'createstaff', 'uses' => 'Admin\AdminController@createstaff'));
    //Edit staff route
    Route::get('editstaff/{staffId}', array('as' => $a . 'editstaff', 'uses' => 'Admin\AdminController@editstaff'));
    Route::post('editstaff', array('as' => $a . 'staffsEdit', 'uses' => 'Admin\AdminController@staffsEdit'));


    Route::get('staffs/create', array('as' => $a . 'create', 'uses' => 'Admin\AdminController@create'));
    Route::post('storestaff', array('as' => $a . 'storestaff', 'uses' => 'Admin\AdminController@storestaff'));


    Route::get('emails', array('as' => $a . 'emails', 'uses' => 'Admin\AdminController@emails'));
    Route::get('notifications', array('as' => $a . 'notifications', 'uses' => 'Admin\AdminController@notifications'));


    Route::group(array('prefix' => 'boxes'), function () {

        $r = 'boxes.';

        Route::get('/', ['as' => $r . 'index', 'uses' => 'BoxController@index']);
        Route::get('create', array('as' => $r . 'create', 'uses' => 'BoxController@create'));
        
        Route::post('create', array('as' => $r . 'store', 'uses' => 'BoxController@store'));
        Route::get('show/{regId}', array('as' => $r . 'show', 'uses' => 'BoxController@show'));
        Route::get('{regId}/edit', array('as' => $r . 'edit', 'uses' => 'BoxController@edit'));
        Route::post('{regId}/update', array('as' => $r . 'update', 'uses' => 'BoxController@update'));
        Route::delete('{regId}/delete', array('as' => $r . 'delete', 'uses' => 'BoxController@destroy'));
        Route::get('{regId}/restore', array('as' => $r . 'restore', 'uses' => 'BoxController@getRestore'));

        Route::get('download', ['as' => $r . 'download', 'uses' => 'BoxController@download']);
    });


    Route::group(array('prefix' => 'users'), function () {

        $au = 'admin.user.';
        Route::get('all', array('as' => $au . 'index', 'uses' => 'Admin\UserController@index'));
        Route::get('{userId}/show', array('as' => $au . 'show', 'uses' => 'Admin\UserController@show'));
        Route::get('{userId}/edit', array('as' => $au . 'edit', 'uses' => 'Admin\UserController@edit'));

        Route::post('{userId}/update', array('as' => $au . 'update', 'uses' => 'Admin\UserController@update'));

        Route::get('{userId}/activate', array('as' => $au . 'activate', 'uses' => 'Admin\UserController@activate'));

    });

    Route::group(array('prefix' => 'staff'), function () {

        $au = 'admin.staff.';
        Route::get('all', array('as' => $au . 'index', 'uses' => 'Admin\StaffController@index'));
        Route::get('{userId}/show', array('as' => $au . 'show', 'uses' => 'Admin\StaffController@show'));
        Route::get('{userId}/edit', array('as' => $au . 'edit', 'uses' => 'Admin\StaffController@edit'));

        Route::post('{userId}/update', array('as' => $au . 'update', 'uses' => 'Admin\StaffController@update'));

    });

    Route::group(array('prefix' => 'reports'), function () {
        $r = 'reports.';

        Route::get('stamps/{startDate}/{endDate}/', array('as' => $r .'stamps', 'uses' => 'ReportsController@estampsReports'));
        Route::get('deliveries/{startDate}/{endDate}/', array('as' => $r .'stamps', 'uses' => 'ReportsController@deliveriesReports'));
        Route::get('pickings/{startDate}/{endDate}/', array('as' => $r .'stamps', 'uses' => 'ReportsController@pickingsReports'));
        Route::get('staff/{startDate}/{endDate}/', array('as' => $r .'stamps', 'uses' => 'ReportsController@staffReports'));
    });
});

Route::group(['prefix' => 'postmaster', 'middleware' => 'admin', 'middleware' => 'auth'], function () // Route::group(['prefix' => 'admin'], function()
{
    $pm = 'pm.';
    Route::get('dashboard', array('as' => $pm . 'dashboard', 'uses' => 'Admin\PMController@dashboard'));

    Route::get('boxes', ['as' => $pm . 'boxes', 'uses' => 'BoxController@pmBoxes']);
    Route::get('agent/collection', array('as' => $pm . 'collection', 'uses' => 'AgentCollectionController@index'));

    Route::get('staff', array('as' => $pm . 'staff', 'uses' => 'Admin\PMController@staff'));
});

Route::group(['prefix' => 'finance', 'middleware' => 'admin', 'middleware' => 'auth'], function () // Route::group(['prefix' => 'admin'], function()
{
    $f = 'finance.';
    Route::get('dashboard', array('as' => $f . 'dashboard', 'uses' => 'Admin\FinanceController@dashboard'));

    Route::get('accounts', array('as' => $f . 'accounts', 'uses' => 'Admin\FinanceController@accounts'));
    Route::get('customer/{corporateID}', array('as' => $f . 'customer', 'uses' => 'Admin\FinanceController@customer'));
    Route::get('customer/{corporateID}/breakdown/{code}', array('as' => $f . 'breakdown', 'uses' => 'Admin\FinanceController@breakDown'));
});

Route::group(['prefix' => 'agentpay', 'middleware' => 'admin', 'middleware' => 'auth'], function () // Route::group(['prefix' => 'admin'], function()
{
    $a = 'agentpay.';
    Route::get('dashboard', array('as' => $a . 'dashboard', 'uses' => 'AgentCollectionController@dashboard'));
    Route::get('agents', array('as' => $a . 'agents', 'uses' => 'AgentCollectionController@agents'));
    Route::get('agents/{id}', array('as' => $a . 'show', 'uses' => 'AgentCollectionController@show'));
});

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {

    $u = 'user.';
    Route::get('account', array('as' => $u . 'dashboard', 'uses' => 'UserController@index'));
    Route::get('profile', array('as' => $u . 'profile', 'uses' => 'UserController@profile'));
    Route::get('{userId}/edit', array('as' => $u . 'edit', 'uses' => 'UserController@edit'));
    Route::get('surrender', array('as' => $u . 'surrender', 'uses' => 'UserController@surrender'));
    Route::get('surrenderNow', array('as' => $u . 'surrender-post', 'uses' => 'UserController@postsurrender'));
    // Route::get('{userId}/edit/pic', array('as' => $u. 'edit', 'uses' => 'UserController@editPic'));
    Route::post('{userId}/update', array('as' => $u . 'update', 'uses' => 'UserController@update'));

    Route::get('change/password', array('as' => $u . 'changepassword', 'uses' => 'UserController@getChangePassword'));
    Route::post('change/password', array('as' => $u . 'changepassword-post', 'uses' => 'UserController@changePassword'));

    Route::get('cert', 'UserController@createCertificate');

    Route::group(array('prefix' => 'agent'), function () {
        $a = 'agent.';

        Route::get('account', array('as' => $a . 'dashboard', 'uses' => 'UserController@agentDashboard'));
        Route::get('commission', array('as' => $a . 'commission', 'uses' => 'UserController@agentCommission'));
        Route::get('create', array('as' => $a . 'create-estamp', 'uses' => 'StampController@create_estamp'));
        Route::get('print', array('as' => $a . 'print-estamp', 'uses' => 'StampController@print_estamp'));
        Route::post('pull', array('as' => $a . 'pull', 'uses' => 'StampController@pull'));

        Route::get('collection', array('as' => $a . 'collection', 'uses' => 'AgentCollectionController@index'));
    });

    Route::group(array('prefix' => 'clerk'), function () {
        $e = 'clerk.';

        Route::get('account', array('as' => $e . 'dashboard', 'uses' => 'UserController@clerkDashboard'));
        Route::get('search', array('as' => $e . 'search-estamp', 'uses' => 'StampController@getSearchEstamp'));
        Route::post('search', array('as' => $e . 'search-estamp-post', 'uses' => 'StampController@searchEstamp'));
        Route::get('underpaid', array('as' => $e . 'underpaid-estamp', 'uses' => 'StampController@getUnderpaidEstamp'));

        Route::get('landing', array('as' => $e . 'landing', 'uses' => 'ClerkController@clerkLanding'));

        Route::get('send-letter', array('as' => $e . 'send-letter', 'uses' => 'ClerkController@sendLetter'));
        Route::get('receive-letter', array('as' => $e . 'receive-letter', 'uses' => 'ClerkController@receiveLetter'));
        Route::get('expired-letter', array('as' => $e . 'expired-letter', 'uses' => 'ClerkController@expiredLetter'));
        Route::get('underpaid-letter', array('as' => $e . 'underpaid-letter', 'uses' => 'ClerkController@underpaidLetter'));

        Route::get('send-parcel', array('as' => $e . 'send-parcel', 'uses' => 'ClerkController@sendParcel'));
        Route::get('receive-parcel', array('as' => $e . 'receive-parcel', 'uses' => 'ClerkController@receiveParcel'));
        Route::get('expired-parcel', array('as' => $e . 'expired-parcel', 'uses' => 'ClerkController@expiredParcel'));
        Route::get('underpaid-parcel', array('as' => $e . 'underpaid-parcel', 'uses' => 'ClerkController@underpaidParcel'));

        Route::get('send-ems', array('as' => $e . 'send-ems', 'uses' => 'ClerkController@sendEms'));
        Route::get('receive-ems', array('as' => $e . 'receive-ems', 'uses' => 'ClerkController@receiveEms'));
    });

    Route::group(array('prefix' => 'dp'), function () {
        $dp = 'dp.';

        Route::get('account', array('as' => $dp . 'dashboard', 'uses' => 'UserController@clerkDashboard'));

        Route::get('landing', array('as' => $dp . 'landing', 'uses' => 'DPController@dpLanding'));
        Route::get('backoffice', array('as' => $dp . 'backoffice', 'uses' => 'DPController@backofficeDelivery'));

    });

    Route::group(array('prefix' => 'estamps'), function () {

        $e = 'estamps.';

        Route::get('/', ['as' => $e . 'index', 'uses' => 'StampController@index']);
        Route::get('corporate', ['as' => $e . 'corporate.index', 'uses' => 'StampController@corporateIndex']);
        Route::get('corporate/batch', ['as' => $e . 'corporate.batch', 'uses' => 'StampController@corporateBatch']);
        Route::get('create', array('as' => $e . 'create', 'uses' => 'StampController@create'));
        
        Route::get('contact', array('as' => $e . 'contact', 'uses' => 'StampController@contact'));
        Route::post('contact', array('as' => $e . 'contactexcel', 'uses' => 'StampController@postContactExcel'));

        //Post bulk estamp
        Route::post('/bulk', ['as' => $e . 'bulk', 'uses' => 'StampController@postBulk']);

        Route::get('show/batch/', ['as' => $e . 'show.batch', 'uses' => 'StampController@showBatch']);
        Route::get('calculate', ['as' => $e . 'calculate.batch', 'uses' => 'StampController@calculateTotal']);

        Route::get('remove', ['as' => $e . 'remove', 'uses' => 'StampController@delete']);

        Route::post('create', array('as' => $e . 'store', 'uses' => 'StampController@store'));
        Route::get('{estampId}', array('as' => $e . 'show', 'uses' => 'StampController@show'));
        Route::get('{estampId}/edit', array('as' => $e . 'edit', 'uses' => 'StampController@edit'));
        Route::post('{estampId}/update', array('as' => $e . 'update', 'uses' => 'StampController@update'));
        Route::post('{estampId}/delete', array('as' => $e . 'delete', 'uses' => 'StampController@destroy'));
        Route::get('{estampId}/restore', array('as' => $e . 'restore', 'uses' => 'StampController@getRestore'));

        Route::get('ems/create', array('as' => 'ems.create', 'uses' => 'EMSController@create'));    
        Route::post('ems/create', array('as' => 'ems.store', 'uses' => 'EMSController@store'));    

        Route::get('view/{id}', ['as' => $e . 'view', 'uses' => 'StampController@viewStamp']);

        //Corporate estamps View
        Route::get('view/{id}/{batchNumber}', ['as' => $e . 'corporate.view', 'uses' => 'StampController@corporateViewStamps']);

        Route::get('download', ['as' => $e . 'download', 'uses' => 'StampController@download']);

        
        // Route::get('/help', array('as' => 'help', 'uses' => 'FrontendController@help'));
    });

    Route::get('/wishes/stamp', array('as' => 'wishes', 'uses' => 'StampController@bestWishes'));

    Route::group(array('prefix' => 'ems'), function () {

        $e = 'ems.';

        Route::get('estamps/{estampId}', ['as' => $e . 'show', 'uses' => 'EMSController@show']);
        Route::get('download', ['as' => $e . 'download', 'uses' => 'EMSController@download']);
    });

    Route::group(array('prefix' => 'season'), function () {

        $e = 'season.';

        // Route::get('estamps/{estampId}', ['as' => $e . 'show', 'uses' => 'EMSController@show']);
        Route::get('download', ['as' => $e . 'download', 'uses' => 'SeasonsController@download']);
    });

    Route::group(array('prefix' => 'normal'), function () {

        $e = 'normal.';

        Route::get('download', ['as' => $e . 'download', 'uses' => 'StampController@download']);
        Route::get('download/edit/{code}', ['as' => $e . 'edit.location', 'uses' => 'StampController@editStampLocation']);
        Route::post('download/{code}/update', array('as' => $e . 'update.location', 'uses' => 'StampController@updateLocation'));

    });

    Route::group(array('prefix' => 'bulk'), function () {

        $b = 'bulk.';

        Route::get('bulk/estamps/{estampId}', ['as' => $b . 'show', 'uses' => 'BulkController@show']);
        Route::get('download', ['as' => $b . 'download', 'uses' => 'BulkController@download']);

    });

    Route::group(array('prefix' => 'registers'), function () {

        $r = 'registers.';

        Route::get('/', ['as' => $r . 'index', 'uses' => 'RegisteredController@index']);
        Route::get('create', array('as' => $r . 'create', 'uses' => 'RegisteredController@create'));
        Route::post('create', array('as' => $r . 'store', 'uses' => 'RegisteredController@store'));
        Route::get('show/{regId}', array('as' => $r . 'show', 'uses' => 'RegisteredController@show'));
        Route::get('{regId}/edit', array('as' => $r . 'edit', 'uses' => 'RegisteredController@edit'));
        Route::post('{regId}/update', array('as' => $r . 'update', 'uses' => 'RegisteredController@update'));
        Route::delete('{regId}/delete', array('as' => $r . 'delete', 'uses' => 'RegisteredController@destroy'));
        Route::get('{regId}/restore', array('as' => $r . 'restore', 'uses' => 'RegisteredController@getRestore'));

        Route::get('download', ['as' => $r . 'download', 'uses' => 'RegisteredController@download']);
    });

    Route::group(array('prefix' => 'batch'), function () {

        $b = 'batch.';

        Route::get('create/{batchNumber}', array('as' => $b . 'create', 'uses' => 'StampController@batchCreate'));
        
        Route::get('show', ['as' => $b . 'show', 'uses' => 'StampController@showMergedBatch']);
    });


    Route::group(array('prefix' => 'deliveries'), function () {

        $d = 'deliveries.';

        Route::get('/', ['as' => $d . 'index', 'uses' => 'DeliveryController@index']);
        Route::get('create/{code}', array('as' => $d . 'create', 'uses' => 'DeliveryController@create'));
        Route::post('create', array('as' => $d . 'store', 'uses' => 'DeliveryController@store'));
        Route::get('{deliveryId}', array('as' => $d . 'show', 'uses' => 'DeliveryController@show'));
        Route::get('{deliveryId}/edit', array('as' => $d . 'edit', 'uses' => 'DeliveryController@edit'));
        Route::post('{deliveryId}/update', array('as' => $d . 'update', 'uses' => 'DeliveryController@update'));
        Route::delete('{deliveryId}/delete', array('as' => $d . 'delete', 'uses' => 'DeliveryController@destroy'));
        Route::get('{deliveryId}/restore', array('as' => $d . 'restore', 'uses' => 'DeliveryController@getRestore'));

    });


    Route::group(array('prefix' => 'pickings'), function () {

        $d = 'pickings.';
        Route::get('New_picking_delivery', array('as' => $d . 'picking_delivery', 'uses' => 'PickingController@general_picking_delivery_get'));
        Route::post('Saving', array('as' => $d . 'save', 'uses' => 'PickingController@general_picking_delivery_save'));

        Route::get('/', ['as' => $d . 'index', 'uses' => 'PickingController@index']);
        Route::get('create/{code}', array('as' => $d . 'create', 'uses' => 'PickingController@create'));
        Route::post('create', array('as' => $d . 'store', 'uses' => 'PickingController@store'));
        Route::get('{pickingId}', array('as' => $d . 'show', 'uses' => 'PickingController@show'));
        Route::get('{pickingId}/edit', array('as' => $d . 'edit', 'uses' => 'PickingController@edit'));
        Route::post('{pickingId}/update', array('as' => $d . 'update', 'uses' => 'PickingController@update'));
        Route::delete('{pickingId}/delete', array('as' => $d . 'delete', 'uses' => 'PickingController@destroy'));
        Route::get('{pickingId}/restore', array('as' => $d . 'restore', 'uses' => 'PickingController@getRestore'));

        Route::group(array('prefix' => 'mail'), function () {

	        $m = 'mail.';

	        Route::get('/', ['as' => $m .'index', 'uses' => 'PickingMailController@index']);
	        Route::get('create', array('as' => $m . 'create', 'uses' => 'PickingMailController@create'));
	        Route::post('create', array('as' => $m . 'store', 'uses' => 'PickingMailController@store'));
	        Route::get('{pickingId}', array('as' => $m . 'show', 'uses' => 'PickingMailController@show'));
	        Route::get('{pickingId}/edit', array('as' => $m . 'edit', 'uses' => 'PickingMailController@edit'));
	        Route::post('{pickingId}/update', array('as' => $m . 'update', 'uses' => 'PickingMailController@update'));
	        Route::delete('{pickingId}/delete', array('as' => $m . 'delete', 'uses' => 'PickingMailController@destroy'));
	        Route::get('{pickingId}/restore', array('as' => $m . 'restore', 'uses' => 'PickingMailController@getRestore'));

	    });
    });


    Route::get('stamp/download', ['as' => 'estamp.download', 'uses' => 'StampController@download']);

    Route::group(array('prefix' => 'notifications'), function () {

        $n = 'notifications.';

        Route::get('/', ['as' => $n . 'index', 'uses' => 'NotificationController@index']);
        Route::get('{notificationId}', array('as' => $n . 'show', 'uses' => 'NotificationController@show'));

    });

    Route::group(array('prefix' => 'emails'), function () {

        $e = 'emails.';

        Route::get('/', ['as' => $e . 'index', 'uses' => 'EmailController@index']);
        Route::get('send', ['as' => $e . 'outbox', 'uses' => 'EmailController@outbox']);

        Route::get('create', array('as' => $e . 'create', 'uses' => 'EmailController@create'));
        Route::post('create', array('as' => $e . 'store', 'uses' => 'EmailController@store'));

        Route::get('care/create', array('as' => $e . 'care.create', 'uses' => 'EmailController@careCreate'));
        Route::post('care/create', array('as' => $e . 'care.store', 'uses' => 'EmailController@careStore'));

        Route::get('{mailId}', array('as' => $e . 'show', 'uses' => 'EmailController@show'));
        Route::get('{mailId}/edit', array('as' => $e . 'edit', 'uses' => 'EmailController@edit'));
        Route::post('{mailId}/update', array('as' => $e . 'update', 'uses' => 'EmailController@update'));
        Route::delete('{mailId}/delete', array('as' => $e . 'delete', 'uses' => 'EmailController@destroy'));
        Route::get('{mailId}/restore', array('as' => $e . 'restore', 'uses' => 'EmailController@getRestore'));


    });

    Route::group(array('prefix' => 'bestwishes'), function () {

        $b = 'bestwishes.';

        Route::get('/', ['as' => $b . 'index', 'uses' => 'BestWishesController@index']);
        Route::get('create', array('as' => $b . 'create', 'uses' => 'BestWishesController@create'));
        Route::post('create', array('as' => $b . 'store', 'uses' => 'BestWishesController@store'));
        Route::post('creates', array('as' => $b . 'storeBulk', 'uses' => 'BestWishesController@storeBulk'));

        Route::get('{bestWishesId}', array('as' => $b . 'show', 'uses' => 'BestWishesController@show'));
        Route::get('{bestWishesId}/edit', array('as' => $b . 'edit', 'uses' => 'BestWishesController@edit'));

        Route::post('{bestWishesId}/update', array('as' => $b . 'update', 'uses' => 'BestWishesController@update'));
        Route::delete('{bestWishesId}/delete', array('as' => $b . 'delete', 'uses' => 'BestWishesController@destroy'));

        Route::get('/view/download', ['as' => $b . 'download', 'uses' => 'BestWishesController@download']);

    });

});

Route::get('test', ['as' => 'test', 'uses' => 'UserController@test']);

Route::get('exportpdf', 'UserController@exportpdf');
Route::get('inpdf', 'UserController@inPdf');
Route::get('fpdi', 'UserController@fpdi');

Route::get('fpdf', function () {

    Fpdf::AddPage();
    Fpdf::SetFont('Courier', 'B', 18);
    Fpdf::Cell(50, 25, 'Hello World!');
    Fpdf::Output();

});

Route::get('pd', function (Codedge\Fpdf\Fpdf\FPDF $fpdf) {

    $fpdf->AddPage();
    $fpdf->SetFont('Courier', 'B', 18);
    $fpdf->Cell(50, 25, 'Hello World!');
    $fpdf->Output();

});

Route::group(['prefix' => 'account/payment', 'middleware' => 'auth'], function () {
    Route::get('make/{amount}', ['as' => 'payment.make', 'uses' => 'TransactionController@accountPayment']);

    Route::get('confirm/{txn_id}', ['as' => 'payment.confirm', 'uses' => 'TransactionController@paymentConfirm']);
    Route::get('confirm/estamp/{txn_id}', ['as' => 'payment.confirm.estamp', 'uses' => 'TransactionController@paymentConfirmEstamp']);
    Route::get('confirm/picking/{txn_id}', ['as' => 'payment.confirm.picking', 'uses' => 'TransactionController@paymentConfirmPicking']);
    //Underpayments success
    Route::get('underpayment/pay/{code}', ['as' => 'payment.underpayment', 'uses' => 'TransactionController@getunderPayments']);
    Route::get('underpayment/paye', ['as' => 'payment.underpayment-success', 'uses' => 'TransactionController@underPaymentSuccess']);
    Route::post('underpayment/paysuccess', ['as' => 'payment.underpayment-post', 'uses' => 'TransactionController@postunderPayments']);
    Route::post('underpayment/payconfirm', ['as' => 'payment.underpayment-confirm', 'uses' => 'TransactionController@postunderPaymentSuccessConfirm']);



    Route::get('iframe', 'TransactionController@iframe');

    Route::get('done', ['as' => 'paymentsuccess', 'uses' => 'PaymentsController@paymentsuccess']);
});

Route::group(['prefix' => 'corporate/account/payment', 'middleware' => 'auth'], function () {
    Route::get('make/{amount}', ['as' => 'corporate.payment.make', 'uses' => 'TransactionController@corporateAccountPayment']);
    Route::get('confirm/{txn_id}', ['as' => 'corporate.payment.confirm', 'uses' => 'TransactionController@paymentConfirm']);
    Route::get('confirm/estamp/{txn_id}', ['as' => 'corporate.payment.confirm.estamp', 'uses' => 'TransactionController@paymentConfirmEstamp']);
    Route::get('confirm/picking/{txn_id}', ['as' => 'corporate.payment.confirm.picking', 'uses' => 'TransactionController@paymentConfirmPicking']);

    Route::get('iframe', 'TransactionController@iframe');

    Route::get('done', ['as' => 'paymentsuccess', 'uses' => 'PaymentsController@paymentsuccess']);
});


Route::group(['prefix' => 'estamp/payment', 'middleware' => 'auth'], function () {
    Route::get('make/{amount}/{code}', ['as' => 'estamp.payment.make', 'uses' => 'TransactionController@estampPayment']);
    Route::get('iframe', 'TransactionController@iframe');
    Route::get('done', ['as' => 'paymentsuccess', 'uses' => 'PaymentsController@paymentsuccess']);
});

Route::group(['prefix' => 'bestwish/payment', 'middleware' => 'auth'], function () {
    Route::get('make/{amount}/{code}', ['as' => 'bestwish.payment.make', 'uses' => 'TransactionController@bestwishPayment']);
    Route::get('iframe', 'TransactionController@iframe');
    Route::get('done', ['as' => 'paymentsuccess', 'uses' => 'PaymentsController@paymentsuccess']);
});

Route::group(['prefix' => 'ems/payment', 'middleware' => 'auth'], function () {
    Route::get('make/{amount}/{code}', ['as' => 'ems.payment.make', 'uses' => 'TransactionController@emsPayment']);
    Route::get('iframe', 'TransactionController@iframe');
    Route::get('done', ['as' => 'paymentsuccess', 'uses' => 'PaymentsController@paymentsuccess']);
});

Route::group(['prefix' => 'registered/payment', 'middleware' => 'auth'], function () {
    Route::get('make/{amount}/{code}', ['as' => 'registered.payment.make', 'uses' => 'TransactionController@registeredPayment']);
    Route::get('iframe', 'TransactionController@iframe');
    Route::get('done', ['as' => 'paymentsuccess', 'uses' => 'PaymentsController@paymentsuccess']);
});

Route::group(['prefix' => 'delivery/payment', 'middleware' => 'auth'], function () {
    Route::get('make/{amount}', ['as' => 'delivery.payment.make', 'uses' => 'TransactionController@deliveryPayment']);
    Route::get('iframe', 'TransactionController@iframe');
    Route::get('done', ['as' => 'paymentsuccess', 'uses' => 'PaymentsController@paymentsuccess']);
});

Route::group(['prefix' => 'picking/payment', 'middleware' => 'auth'], function () {
    Route::get('make/{amount}', ['as' => 'picking.payment.make', 'uses' => 'TransactionController@pickingPayment']);
    Route::get('iframe', 'TransactionController@iframe');
    Route::get('done', ['as' => 'paymentsuccess', 'uses' => 'PaymentsController@paymentsuccess']);
});

Route::group(['prefix' => 'bulk/payment', 'middleware' => 'auth'], function () {
    Route::get('make/{amount}', ['as' => 'bulk.payment.make', 'uses' => 'TransactionController@bulkPayment']);
    Route::get('iframe', 'TransactionController@iframe');
    Route::get('done', ['as' => 'paymentsuccess', 'uses' => 'PaymentsController@paymentsuccess']);
});



Route::group(['prefix' => 'advance/customer', 'middleware' => 'auth'], function () {
    Route::get('make/{amount}/{uniqueNumber}', ['as' => 'advance.customer.proceed', 'uses' => 'BulkController@advanceCustomer']);
});

Route::group(['prefix' => 'account/customer', 'middleware' => 'auth'], function () {
    Route::get('make/{amount}/{uniqueNumber}', ['as' => 'account.customer.proceed', 'uses' => 'BulkController@accountCustomer']);
});

// Success Routes
Route::group(['prefix' => 'success'], function () {

    $s = 'success.';
    Route::get('registration',          ['as' => $s.'registration.payment', 'uses' => 'PaymentsController@accountPayment']);
    Route::get('stamppay',              ['as' => $s.'estamp.payment', 'uses' => 'PaymentsController@stampPayment']);
    Route::get('bestwishpay',           ['as' => $s.'bestwish.payment', 'uses' => 'PaymentsController@bestwishPayment']);
    Route::get('ems',                   ['as' => $s.'ems.payment', 'uses' => 'PaymentsController@emsPayment']);
    Route::get('registeredpay',         ['as' => $s.'registered.payment', 'uses' => 'PaymentsController@registeredPayment']);
    Route::get('registered-mail-pay',   ['as' => $s.'registered_mail.payment', 'uses' => 'PaymentsController@registeredMailPayment']);
    Route::get('deliverypay',           ['as' => $s.'delivery.payment', 'uses' => 'PaymentsController@deliveryPayment']);
    Route::get('pickingpay',            ['as' => $s.'picking.payment', 'uses' => 'PaymentsController@pickingPayment']);
    Route::get('registered',            ['as' => $s.'registered.payment', 'uses' => 'PaymentsController@registeredMailPayment']);
    Route::get('bulkpay',               ['as' => $s.'bulk.payment', 'uses' => 'PaymentsController@bulkMailPayment']);
});

Route::get('/callback', 'NotificationController@notification');

Route::get('/app/{data}/', 'NotificationController@mobileApp');
Route::get('/app/parcel/{data}/', 'NotificationParcelController@mobileApp');
Route::get('/app/ems/{data}/', 'NotificationEMSController@mobileApp');

Route::get('pay', function(){

    return view('frontend.webpayment');
});

Route::group(['prefix' => 'mobile/payment', 'middleware' => 'auth'], function () {
    Route::get('/account/', ['as' => 'mpesa.payment', 'uses' => 'PaymentsController@mobileTest']);
    Route::get('/git/', ['as' => 'mpesa.payment', 'uses' => 'PaymentsController@clientGit']);
});


Route::post('/sms/', 'PaymentsController@smsCallback');
Route::post('/sms/v2', 'PaymentsController@smsCallbackV2');

Route::get('/test/sms/{phone}/{msg}', 'SendSMSController@sendSms');

Route::post('/one/{data}', 'PaymentsController@callbackMobile');


Route::post('/paybill/{name}/{mpesa}/{amount}/{transation_time}', 'PaymentsController@paybill');
Route::get('/paybill_payment', 'PaymentsController@paybill_payment');


Route::get('fake/user', 'Auth\AuthController@fakeUser');
Route::get('fake/pmg', 'Auth\AuthController@fakePMG');

Route::get('free/riders', 'Admin\StaffController@freeRiders');

Route::get('menu', function(){
    // \Alert::info('Welcome back');
    // return view('test');
    $email = DB::table('users')->where('phone', $sender_phone)->value('email');
});

Route::get('qrcode', 'FrontendController@qrcode');
Route::get('carbon', 'FrontendController@carbon');

Route::group(array('prefix' => 'reports'), function () {

    $c = 'reports.';

    Route::get('/', ['as' => $c. 'reports.index', 'uses' => 'ReportsController@index']);
});

Route::group(array('prefix' => 'crons'), function () {

	$c = 'crons.';

	Route::get('once-every-minute', ['as' => $c. 'onceeveryminute', 'uses' => 'ReminderController@onceEveryMinute']);
    Route::get('account-activation', array('as' => $c. 'onceeverytwominutes', 'uses' => 'ReminderController@onceEveryTwoMinutes'));
    Route::get('account-renewal', array('as' => $c. 'onceeverythreeminutes', 'uses' => 'ReminderController@onceEveryThreeMinutes'));
});
		
Route::get('update/noreply/from', 'EmailController@updateNoreplyFrom');
Route::get('update/noreply/to', 'EmailController@updateNoreplyTo');
Route::get('add/postcode', 'UserController@addPostcode');

Route::get('delete/users', 'UserController@deleteUsers');
