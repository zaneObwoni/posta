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
                                                Your Registered Picking Details
                                            </h2>
                                        </p>
                                    </div>

                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a> <i class="fa fa-tasks"></i> Name: <span class="pull-right"><b>{!! $pickingmail->name !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> ID Number: <span class="pull-right"><b>{!! $pickingmail->id_number !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Phone: <span class="pull-right"><b>{!! $pickingmail->phone !!}</b></span></a></li>

                                        <li><a> <i class="fa fa-tasks"></i> Secret Code: <span class="pull-right"><b>{!! $pickingmail->tracking_code !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Stamp Code: <span class="pull-right"><b>{!! $pickingmail->stamp_code !!}</b></span></a></li>
                                      
                                        
                                    </ul>

                                </section>
                                <div>
                                    NOTE! Please write down the Reference Code and forward it to the Intended recipient. This is the secret code they will need to collect the Registered letter from the Post Office.
                                </div>
                            </aside>
                            <!--widget end-->            
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
	
			