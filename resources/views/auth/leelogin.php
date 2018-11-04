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
                background-color: #ffffff;
                /**font-weight: 100;
                font-family: 'Lato', sans-serif;*/
            }
            
            p{
                color:black;
                font-size: 17px;
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
            .site-footer
            {
                padding-top: 100px;

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
                <h2>VirtualPost</h2>
            </div>
        </div>   

        <br>
        <br>
        <br>
        <div>
            <p style="color: #000 !important;">
                Welcome to e-Njiwa – Postal Corporation of Kenya’s end-to-end online Service.
                Here you will enjoy all postal services without visiting a Post Office.
               <br> e-Njiwa is your Post Office at home, in the office, or on-the-go!
            </p>
            
            <br><br>
            <span style="color: #000;">
                <b>
                    NOTE: 
                </b>
                    This Virtual Post Office box costs KES 600/- (INDIVIDUAL) and KES 2000/- (CORPORATE) and is renewable annually.                
            </span>

            <br><br>
            <span>
                <b>
                    Already have a Physical Box? <a href="{!! route('physical.choose') !!}">Click Here.</a>
                </b>
            </span>
        </div>


        <br><br><br>
        <!--main content start-->
        <section id="main-content">
            <div class="todo-action-bar">
                <div class="row">
                    <div class="col-xs-4 btn-todo-select">
                        <a href="{!! route('auth.login') !!}">
                            <button class="btn btn-default" type="submit" style="background-color: blue; border-color: blue; font-size: 16px; font-weight: bold">
                                <i class="fa fa-sign-in"></i> 
                                Login
                            </button>
                        </a>
                    </div>
                    <div class="col-xs-4 btn-add-task">
                        <a href="{!! route('auth.registerall') !!}">
                            <button class="btn btn-default btn-primary" type="submit" style="background-color: red;border-color: red;font-size: 16px; font-weight: bold">
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
    <footer class="site-footer" class="pull-down">

        <div class="text-center" style="">
            2016 &copy; Postal Corporation of Kenya. For more Information visit <a href="http://posta.co.ke" style="color:#1896D7;" target="_blank">www.posta.co.ke</a>
            <div class="pull-right">
                Powered by
                <a href="http://simpay.co.ke" target="_blank">
                    <img src="/images/simpay-70.png">
                </a>
            </div>
        </div>
    </footer>
@stop

@section('js')
    @include('includes.js')
@stop

