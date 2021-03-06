@extends('layouts.dash')

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
		                <!-- <section class="panel"> -->
		                <br>
		                    <div class="panel-body">
		                        <div class="position-center">
		                            
		                            {!! Form::open(['url' => route('user.changepassword-post'), 'class' => 'form-horizontal' ] ) !!}
                                		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
			                            <div class="form-group">
			                            	{!! Form::label('password', 'Enter a new password:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
			                            	<div class="col-lg-10">
		                                        {!! Form::password('password', null, [
		                                            'class'                         => 'form-control',
		                                            'placeholder'                   => 'ie. 0716234783',
		                                            'required',
		                                            'id'                            => 'inputpassword',
		                                            'data-parsley-required-message' => 'password is required',
		                                            'data-parsley-trigger'          => 'change focusout',
		                                            'data-parsley-type'             => 'password'
		                                            
		                                        ]) !!}
			                                </div>
			                            </div>

			                            <div class="form-group">
			                            	{!! Form::label('repeat_password', 'Repeat Password:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
			                            	<div class="col-lg-10">
		                                        {!! Form::password('repeat_password', null, [
		                                            'class'                         => 'form-control',
		                                            'placeholder'                   => 'ie. 0716234783',
		                                            'required',
		                                            'id'                            => 'inputpassword',
		                                            'data-parsley-required-message' => 'password is required',
		                                            'data-parsley-trigger'          => 'change focusout',
		                                            'data-parsley-type'             => 'password'
		                                            
		                                        ]) !!}
			                                </div>
			                            </div>
			 							
			 							<br>
			                            <div class="form-group">
			                                <div class="col-lg-offset-2 col-lg-10">
			                                	<!-- <button class="button">Sign in</button> -->
			                                    <button type="submit" class="btn btn-danger">Change Your Password</button>
			                                </div>
			                            </div>
			                        {!! Form::close() !!}
		                        </div>
		                    </div>
		                <!-- </section> -->

		                <br><br>
		                <div>
		                	<a href="{!! route('home') !!}">Back Home</a>
		                </div>
		            </div>
		        </div>
	    	</section>
	    </section>
	</div>
@stop