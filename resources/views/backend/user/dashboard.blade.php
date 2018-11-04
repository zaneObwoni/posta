@extends('layouts.dash')

<script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>

@section('css')
    <style type="text/css">
        .footer{
          position:fixed;
          bottom:0;
          right:0;
          left:0;
          background:#000;
          padding:10px;
          box-sizing:border-box;
        }
    </style>
@stop

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">

            @if(Auth::User()->active == 0)

            <!--mini statistics end-->


                <div class="col-md-12">
                      <div class="col-md-12">
                        <div class="mini-stat clearfix">
                            <a href="{!! route('success') !!}">
                                <div class="mini-stat-info">
                                @if($user->code == 1111)
                                    <span>
                                        Thank you {!! $user->first_name !!} for registering your physical box number on this platform! But we are sorry that you can't operate this account just yet. This is because we are still verifying the information you provided to ascertain ownership. We shall notify you as soon as the process is complete. Kindly bear with us. Thank you.
                                    </span>
                                @else
                                    <span>Please Pay to Unlock your Account</span>
                                @endif
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--mini statistics end-->

            @else
            <!--mini statistics end-->
            <div class="row">
                <div class="col-md-12">                
                    <div class="col-md-6">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon orange"><i class="fa fa-envelope-o"></i></span>
                            <a href="{!! route('emails.index') !!}">
                                <div class="mini-stat-info">
                                    <span>Emails</span>                            
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon orange"><i class="fa fa-bell-o"></i></span>
                            <a href="#">
                                <div class="mini-stat-info">
                                    <span>Notifications</span>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon green"><i class="fa fa-envelope-o"></i></span>
                            <a href="{!! route('estamps.create') !!}">
                                <div class="mini-stat-info">
                                    <span>Post Letter</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon green"><i class="fa fa-user"></i></span>
                            <a href="{!! route('user.profile') !!}">
                                <div class="mini-stat-info">
                                    <span>Manage Account</span>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon orange"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                            <a href="{!! route('pickings.picking_delivery') !!}">
                                <div class="mini-stat-info">
                                    <span>Request Pick Up / Delivery</span>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <!--mini statistics end-->
            @endif
        </section>
    </section>
    <!--main content end-->

    <div class=".footer">
        <h2>Sticky Footer</h2>
    </div> 


    

@stop

@section('js')
    @include('includes.js')
@stop