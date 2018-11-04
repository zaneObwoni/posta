@extends('layouts.dash')

@section('content')


    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="col-md-9">                                
                                <!--widget start-->
                                <aside class="profile-nav alt">
                                    <section class="panel">
                                        <div class="user-heading alt">                                                
                                            <p>
                                                <b>{!! $notification->title !!}</b>
                                            </p>
                                        </div>

                                        <ul class="nav nav-pills nav-stacked">
                                            <li><a> <i class="fa fa-tasks"></i> <b>Content</b> : <span>{!! $notification->content !!}</span></a></li>
                                            <li><a> <i class="fa fa-tasks"></i> <b>Sender Phone Number</b> : <span class="pull-right">{!! $notification->sender_phone !!}</span></a></li>
                                            <li><a> <i class="fa fa-tasks"></i> <b>Recipient Phone NUmber</b> : <span class="pull-right">{!! $notification->recipient_phone !!}</span></a></li>
                                            
                                        </ul>

                                    </section>
                                </aside>
                                <!--widget end-->
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
	
			