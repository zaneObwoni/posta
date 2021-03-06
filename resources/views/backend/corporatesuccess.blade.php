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
		            
		            <div class="col-lg-12">
		                <section class="panel" style="padding:2%;">
		                	<!-- <h4>Thank you! </h4> -->
							<!-- <h4>Your Registration was successful.</h4> -->
							<h4>You have been allocated P.O Box Number {!! $user->postbox_id !!}-{!! $user->postcode_id !!}, {!! $user->town !!}</h4>
							<h4>Your email at Posta is  -  {!! $user->email !!}<br><br>The Cost of the Box is KES. 2000/-(Renewable Annually)<br><br></h4>

							<a href="{!! route('corporate.payment.make', 2000) !!}">
								<button>
									<h4>Please! Make Payment for your Box</h4>
								</button>
							</a>
							<br><h4> or </h4>
							<a href="{!! route('user.dashboard') !!}">
								<button>
									<h4>
										Go to your Dashboard
									</h4>
								</button>
							</a>

						</section>

		            </div>
		        </div>
	    	</section>
	    </section>
	</div>
@stop
