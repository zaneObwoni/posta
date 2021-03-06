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
        <div>
            <p style="color:#000!important;">
               Create Password
            </p>
        </div>


		<!--main content start-->
	    <section id="" class="" style="margin-top:-5%">
	        <section class="wrapper">
	        <!-- page start-->
		        <div class="row">
					@include('includes.errors')
		            
		            <div class="col-lg-12">
		                <section class="panel">
		                    <header class="panel-heading">
		                        Type New Password ( You registered with USSD)
		                    </header>
		                    <div class="panel-body">
		                        <div class="position-center">
		                            
		                            {!! Form::open(['url' => route('auth.password'), 'class' => 'form-horizontal' ] ) !!}
                                		<input type="hidden" name="_token" value="{!! csrf_token() !!}">
			                            <div class="form-group">
			                            	{!! Form::label('email', 'Your Email:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
			                            	<div class="col-lg-10">
		                                        {!! Form::email('email', null, [
		                                            'class'                         => 'form-control',
		                                            'placeholder'                   => 'e.g 100000-00100@posta.co.ke',
		                                            'required',
		                                            'id'                            => 'inputEmail',
		                                            'data-parsley-required-message' => 'Email is required',
		                                            'data-parsley-trigger'          => 'change focusout',
		                                            'data-parsley-type'             => 'email'
		                                            
		                                        ]) !!}
			                                </div>
			                            </div>
			                            <div class="form-group">
			                                {!! Form::label('password', 'Password:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
			                                <div class="col-lg-10">
			                                    {!! Form::password('password', [
	                                                'class'                         => 'form-control',
	                                                'placeholder'                   => 'Enter Password',
	                                                'required',
	                                                'id'                            => 'inputPassword',
	                                                'data-parsley-required-message' => 'Password is required',
	                                                'data-parsley-trigger'          => 'change focusout',
	                                                'data-parsley-minlength'        => '2',
	                                                'data-parsley-maxlength'        => '20'
	                                            ]) !!}
			                                </div>
			                            </div>
									<div class="form-group">
										{!! Form::label('cpassword', 'Confirm Password:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
										<div class="col-lg-10">
											{!! Form::password('cpassword', [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Confirm Password',
                                                'required',
                                                'id'                            => 'inputPassword',
                                                'data-parsley-required-message' => 'Confirm Password is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-minlength'        => '2',
                                                'data-parsley-maxlength'        => '20'
                                            ]) !!}
										</div>
									</div>
			                            <div class="form-group">
			                                <div class="col-lg-offset-2 col-lg-10">
			                                    <div class="checkbox">
			                                        <label>
			                                            <input type="checkbox"> Remember me
			                                        </label>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="form-group">
			                                <div class="col-lg-offset-2 col-lg-10">
			                                	<!-- <button class="button">Sign in</button> -->
			                                    <button type="submit" class="btn btn-danger">Save & Login</button>
			                                </div>
			                            </div>
			                        {!! Form::close() !!}
		                        </div>

		                        <p>Don't have a Post Office Box Number? 
		                        	<a href="{{ route('auth.registerall') }}" class="goto-signup soap-popupbox" >
			                        	Get a Post Office Box Number 
			                        </a>
			                    </p>
		                    </div>
		                </section>

		            </div>
		        </div>
	    	</section>
	    </section>
	</div>
@stop