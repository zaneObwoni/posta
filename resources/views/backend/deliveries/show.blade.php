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
                                                Your Delivery Details
                                            </h2>
                                        </p>
                                    </div>

                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a> <i class="fa fa-tasks"></i> Stamp Code: <span class="pull-right"><b>{!! $delivery->stamp_code !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Delivery Building: <span class="pull-right"><b>{!! $delivery->building_name !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Delivery Street: <span class="pull-right"><b>{!! $delivery->street !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Delivery Town: <span class="pull-right"><b>{!! $delivery->town !!}</b></span></a></li>

                                        <li><a> <i class="fa fa-tasks"></i> Recipient Full Names: <span class="pull-right"><b>{!! $delivery->fullname !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Recipient Phone: <span class="pull-right"><b>{!! $delivery->phone !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Delivery Amount: <span class="pull-right"><b>KShs. {!! $delivery->amount !!}</b></span></a></li>
                                      
                                        
                                    </ul>

                                </section>
                            </aside>
                            <!--widget end-->

                            <div>
                                <a href="{!! route('delivery.payment.make', $delivery->amount) !!}">
                                    <button>
                                        <h4>
                                            Please Pay for your Delivery
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
	
			