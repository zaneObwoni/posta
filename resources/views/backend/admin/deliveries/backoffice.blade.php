@extends('layouts.dash')

@section('css')
    <style type="text/css">

        .lefty{
            padding-right: 3%;
        }

        .border{
            height:140px;
            width:40%;
            border:2px solid grey;
        }

        .box{
            margin: 1px 0 0 2.8%;
            color:#000;font-size:16px;
            background-color: #fff;
            width: 80%;
            padding: 2%
        }

        .header-top{
            width:45px;
            margin-top:-13px;
            margin-left:5px;
            background:white;
        }

        .btn{
            width: 95px;
        }
    </style>
@stop

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="row">
                        <div class="col-md-12">

                                    <br>
                                    <div class="box">
                                        <div class="border pull-right">
                                            <div class="header-top">Parcel</div>
                                            <div style="padding: 2%; padding-left:15%; margin-top:15px;">
                                                <a href="{!! route('clerk.send-parcel') !!}">
                                                    <button type="button" class="btn btn-info">Sender</button>
                                                </a>
                                                <a href="{!! route('clerk.receive-parcel') !!}">
                                                    <button type="button" class="btn btn-info">Receiver</button>                                                
                                                </a>
                                                
                                            </div>

                                            <div style="padding: 2%;  padding-left:15%; margin-top:5px;">
                                                <a href="{!! route('clerk.expired-parcel') !!}">
                                                    <button type="button" class="btn btn-info">Expired</button>
                                                </a>
                                                <a href="{!! route('clerk.underpaid-parcel') !!}">
                                                    <button type="button" class="btn btn-info">Underpaid</button>
                                                </a>
                                            </div>
                                        </div>


                                        <div class="border">
                                            <div class="header-top">Letter</div>
                                            <div style="padding: 2%; padding-left:15%; margin-top:15px;">
                                                <a href="{!! route('clerk.send-letter') !!}">
                                                    <button type="button" class="btn btn-info">Sender</button>
                                                </a>
                                                <a href="{!! route('clerk.receive-letter') !!}">
                                                    <button type="button" class="btn btn-info">Receiver</button>                                                
                                                </a>
                                                
                                            </div>

                                            <div style="padding: 2%;  padding-left:15%; margin-top:5px;">
                                                <a href="{!! route('clerk.expired-letter') !!}">
                                                    <button type="button" class="btn btn-info">Expired</button>
                                                </a>
                                                <a href="{!! route('clerk.underpaid-letter') !!}">
                                                    <button type="button" class="btn btn-info">Underpaid</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="box">
                                        <!-- <div class="border pull-right">
                                            <div class="header-top">Parcel</div>
                                            <div style="padding: 2%; padding-left:15%; margin-top:15px;">
                                                <button type="button" class="btn btn-info">Sender</button>
                                                <button type="button" class="btn btn-info">Receiver</button>
                                                
                                            </div>

                                            <div style="padding: 2%;  padding-left:15%; margin-top:5px;">
                                                <button type="button" class="btn btn-info">Expired</button>
                                                <button type="button" class="btn btn-info">Underpaid</button>
                                            </div>
                                        </div> -->

                                        <div class="border">
                                            <div class="header-top">EMS</div>
                                            <div style="padding: 2%; padding-left:15%; margin-top:15px;">
                                                <a href="{!! route('clerk.send-ems') !!}">
                                                    <button type="button" class="btn btn-info">Sender</button>
                                                </a>
                                                <a href="{!! route('clerk.receive-ems') !!}">
                                                    <button type="button" class="btn btn-info">Receiver</button>                                                
                                                </a>
                                            </div>
                                        </div>
                                    </div>

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
