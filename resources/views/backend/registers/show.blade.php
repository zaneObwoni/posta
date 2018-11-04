@extends('layouts.dash')

@section('content')

    
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="row">
                        <div class="col-md-6" style="margin-left:5%;">
                           
                            <!--widget start-->
                            <aside class="profile-nav alt">
                                <section class="panel">
                                    <div style="padding: 2px 0 0 5%;">                                                
                                        <p>
                                            <h2 style="color:#000;">
                                                Your Registered Mail Details
                                            </h2>
                                        </p>
                                    </div>

                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a> <i class="fa fa-tasks"></i> Sender Phone: <span class="pull-right"><b>{!! $registered->sender_phone !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Sender Name: <span class="pull-right"><b>{!! $registered->sender_name !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Destination Box : <span class="pull-right"><b>{!! $registered->destination_box !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Destination Code : <span class="pull-right"><b>{!! $registered->destination_code !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Origin Town : <span class="pull-right"><b>{!! $registered->origin_town !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Destination Town : <span class="pull-right"><b>{!! $registered->destination_town !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Recipient Phone : <span class="pull-right"><b>{!! $registered->recipient_phone !!}</b></span></a></li> 
                                        <li><a> <i class="fa fa-tasks"></i> Recipient Name : <span class="pull-right"><b>{!! $registered->recipient_name !!}</b></span></a></li>                                        
                                        <li><a> <i class="fa fa-tasks"></i> Stamp Price : <span class="pull-right"><b style="font-size:20px;">KShs: {!! $registered->price!!}</b></span></a></li>
                                    </ul>

                                </section>
                            </aside>
                            <!--widget end-->

                            <div>
                                <a href="/registered/payment/make/{!! $registered->price !!}/{!! $registered->id !!}"> 
                                
                                    <button>
                                        <h4>
                                            Please Pay for your Registered Mail
                                        </h4>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--mini statistics end-->            
        </section>
    </section>
    <!--main content end-->    

@stop

@section('js')
    @include('includes.js')
@stop
	
			