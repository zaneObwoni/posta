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

                <br><br>

        <h2>Choose Type of registration</h2>


        <div>
            <p style="color: #000 !important;">
                If you are an INDIVIDUAL in need of a Post Office Box (Personal Registration)               
            </p>
            
            <br>
            <p style="color:#000;">
              If you are a Registered Business in need of a Post Office Box (Corporate Registration)
            </p>

        </div>


        <br>


        <!--main content start-->
        
        <section id="main-content">

            <div class="todo-action-bar">
                <div class="row">
                    <div class="col-xs-4 btn-todo-select">
                        <a href="{!! route('auth.register') !!}">
                            <button class="btn btn-default btn-info" type="submit">
                                <i class="fa fa-user"></i>
                                <h4>
                                    PERSONAL
                                </h4>                                
                            </button>
                        </a>
                    </div>

                    <div class="col-xs-4 btn-add-task">


                        <a href="{!! route('auth.corporate') !!}">
                            <button class="btn btn-default btn-info" type="submit">
                                <i class="fa fa-home"></i>
                                <h4>
                                    CORPORATE 
                                </h4>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!--main content end-->

    </div>

@stop

@section('js')
    @include('includes.js')
@stop

