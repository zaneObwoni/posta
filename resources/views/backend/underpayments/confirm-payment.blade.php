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
                            <section class="panel" style="padding:2%;">
                                <h4>{!! $resp['result']['CUST_MSG']   !!} </h4>

                                After completing the payment on your phone, click on confirm payment.<br/>
                                If you do not get a prompt on your phone, click on restart payment to restart the
                                payment.<br/>
                                <p></p>


                                <a href="{!! route($confirm_link, 'trans_id='.$resp['data']['transaction_id'].'&code='.$code) !!}">
                                    <button>
                                        <h4>Confirm Payment</h4>
                                    </button>
                                </a>
                                <br><h4> or </h4>
                                <a href="/estamp/payment/make/{!!$amount!!}/{!!$code!!}">
                                    <button>
                                        <h4>
                                            Restart payment
                                        </h4>
                                    </button>
                                </a>

                            </section>

                        </div>
                    @else
                        <div class="col-lg-12">
                            <section class="panel" style="padding:2%;">

                                After completing the payment on your phone, click on confirm payment.<br/>
                                If you do not get a prompt on your phone<br/>
                                <p></p>

                                <a href="{!! route('payment.underpayment-success','trans_id='.$resp['data']['transaction_id'].'&stamp_code='.$stamp_code) !!}">
                                    <button>
                                        <h4>Confirm Payment</h4>
                                    </button>
                                </a>

                            </section>

                        </div>

                    @endif
                </div>
            </section>
        </section>
    </div>
@stop
