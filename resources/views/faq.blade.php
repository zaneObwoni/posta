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
        <div>
            <p style="color:#000!important;">
                Welcome to e-Njiwa – Postal Corporation of Kenya’s end-to-end online Service.
                Here you will enjoy all postal services without visiting a Post Office.
                e-Njiwa is your Post Office at home, in the office, or on-the-go!
            </p>
            
            <br><br>
            <span style="color:#000;">
                <b>
                    NOTE: 
                </b>

                    This is a subscription service. To Register, please send the word <b>MAIL</b> to <b>40567</b>. The notification will cost you 10/-.
                
            </span>

        </div>


        <br><br><br>
        <!--main content start-->
        <section id="main-content">
            <div class="todo-action-bar">
                <div class="row">
                    <div class="col-xs-4 btn-todo-select">
                        <a href="{!! route('auth.login') !!}">
                            <button class="btn btn-default" type="submit">
                                <i class="fa fa-sign-in"></i> 
                                Login
                            </button>
                        </a>
                    </div>

                    <div class="col-xs-4 btn-add-task">
                        <a href="{!! route('auth.registerall') !!}">
                            <button class="btn btn-default btn-primary" type="submit">
                                <i class="fa fa-user"></i>
                               Register
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

