@extends('layouts.master')


@section('css')
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                color:#000;
                /**font-weight: 100;
                font-family: 'Lato', sans-serif;*/
            }
            
            p{
                color:black;
                font-size: 18px;
            }

            span{
                color:black;
                font-size: 16px;
            }


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
            <div class="title">
                <a class="logo" href="#">
                    <img alt="" src="/images/logo.png" width="70%">                    
                </a>
            </div>
        </div>
        <div>
            <p style="color:#000!important;">

            </p>
            
            <br><br>
            <span style="color:#000;">
                Page Coming Soon
            </span>

        </div>

        <!--main content start-->
        <!--main content end-->

    </div>
   
@stop

@section('js')
    @include('includes.js')
@stop

