@extends('layouts.master')

@section('css')

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        /*body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            color: #000;
            font-family: 'Lato', sans-serif;
        }*/

        .container {
            text-align: center;
            /*display: table-cell;*/
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
    </style>
@stop

@section('content')

    <div class="container">
        <div class="content">
            <a href="{!! route('home') !!}">
                <div class="title">
                    <div class="title">
                        <a class="logo" href="#">
                            <img alt="" src="/images/logo.png">
                        </a>
                    </div>
                </div>
            </a>
        </div>

        @include('includes.errors')

                <!--main content start-->
        <section id="" class="">
            <section class="wrapper">
                <!-- page start-->
                <div class="row">
                    @if(!empty($code))

                        <div class="col-lg-12">
                            <section class="panel" style="padding:2%; padding-bottom: 5%">
                                <h4>
                                    {!! $resp['result']['CUST_MSG']; !!}
                                </h4>

                                <span style="font-size: 17px;">
                                    <b>IMPORTANT. READ THIS FIRST!</b>
                                    <br><br>
                                    1. After completing the payment on your phone, please wait for the M-PESA confirmation message then click on <b>Confirm Payment</b>.<br/>
                                    2. Should the prompt delay to appear on your phone screen, click on <b>Restart Payment</b>.
                                    <br>
                                    3. Please contact Customer Care should the system prompt you to pay again after a successful M-PESA payment. 
                                </span>

                                <br/>
                                <p></p>

                                <br><br>

                                <div>
                                    <a href="{!! route($confirm_link, 'trans_id='.$resp['data']['transaction_id'].'&code='.$code) !!}" class="pull-right">
                                        <button>
                                            <h4>Confirm Payment</h4>
                                        </button>
                                    </a>
                                    <!-- <br><h4> or </h4> -->

                                    @if(Request::segment(1) == 'ems')
                                        <a href="/ems/payment/make/{!!$amount!!}/{!!$code!!}" class="pull-left">
                                            <button>
                                                <h4>
                                                    Restart Payment
                                                </h4>
                                            </button>
                                        </a>
                                    @else
                                        <a href="/estamp/payment/make/{!!$amount!!}/{!!$code!!}" class="pull-left">
                                            <button>
                                                <h4>
                                                    Restart Payment
                                                </h4>
                                            </button>
                                        </a>
                                    @endif
                                </div>
                            </section>

                        </div>
                    @else
                        <div class="col-lg-12">
                            <section class="panel" style="padding:2%; padding-bottom: 7%"">
                                <h4>
                                    {!! $resp['result']['CUST_MSG']; !!}
                                </h4>

                                <span style="font-size: 17px;">
                                    <b>IMPORTANT. READ THIS FIRST!</b>
                                    <br><br>
                                    1. After completing the payment on your phone, please wait for the M-PESA confirmation message then click on <b>Confirm Payment</b>.<br/>
                                    2. Should the prompt delay to appear on your phone screen, click on <b>Restart Payment</b>.
                                    <br>
                                    3. Please contact Customer Care should the system prompt you to pay again after a successful M-PESA payment. 
                                </span>
                                <br><br>
                                <p></p>

                                <div>
                                    <a href="{!! route($confirm_link, 'trans_id='.$resp['data']['transaction_id']) !!}" class="pull-right">
                                        <button>
                                            <h4>Confirm Payment</h4>
                                        </button>
                                    </a>
                                    <a href="{!! route($link , $resp['data']['amount'])!!}" class="pull-left">
                                        <button>
                                            <h4>
                                                Restart payment
                                            </h4>
                                        </button>
                                    </a>
                                </div>
                            </section>

                        </div>

                    @endif
                </div>
            </section>
        </section>
    </div>
@stop
