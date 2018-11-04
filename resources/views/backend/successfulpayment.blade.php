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
		                	<h4>Description: {!! $resp['data']['DESCRIPTION'];   !!} </h4>
		                	<h4>Status: {!! $resp['data']['TRX_STATUS'];   !!} </h4>
		                	<p></p>
		                	<a href="{!! route($link) !!}">
								<button>
									<h4>
										Continue
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
