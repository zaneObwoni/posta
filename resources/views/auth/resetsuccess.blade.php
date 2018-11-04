@extends('layouts.master')

@section('css')

	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

          /*  body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                color:#000;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
                font-family: 'Arial';
            }*/
            
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
        </style>
@stop

@section('content')

	<div class="container">
		<div class="content">
			<a href="{!! route('home') !!}">
	        	<div class="title">
	        		<div class="title">
		                <a class="logo" href="{!! route('home') !!}">
		                    <img alt="" src="/images/logo.png" width="70%">                    
		                </a>
		            </div>
	        	</div>
	        </a>
	    </div>   

		<!--main content start-->
	    <section id="" class="" style="margin-top:-5%">
	        <section class="wrapper">
	        <!-- page start-->
		        <div class="row">
		        @include('includes.errors')
		            
		            <div class="col-lg-12">
		                <section class="panel">

		                    <div class="panel-body">
		                        <div class="position-center">
		                            <br><br><br><br><br><br>
		                            Your password has been reset successful. Use the code you received on your phone to login to your account.
		                            <br><br><br>
		                        </div>
		                    </div>
		                </section>
		                <div>
		                	<a href="{!! route('auth.login') !!}">Login</a>
		                </div>
		            </div>
		        </div>
	    	</section>
	    </section>
	</div>
@stop