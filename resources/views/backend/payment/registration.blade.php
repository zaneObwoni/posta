@extends('layouts.dash')

@section('content')

    <!--main content start-->
    <section id="main-content">  

        <section>
        	<div class="container">

			    @include('includes.errors')
		        
		        
				<!--main content start-->
			    <section id="" class="">
			        <section class="wrapper">
			        <!-- page start-->
				        <div class="row">
				            
				            <div class="col-lg-12" style="text-align:center;">
				                <section>

				                	<div style="color:#;">
										<h4>Successful.</h4>
										
										<h4>Your Payment for P.O. Box Number: {!! $user->postbox_id !!}-{!! $user->postcode_id !!}, {!! $user->town !!}  has been received.</h4>

										<h4>Thank you for Registering.</h4>
									</div>
								</section>

				            </div>
				        </div>
			    	</section>
			    </section>
			</div>
        </section>
    </section>
    <!--main content end-->
    

@stop

@section('js')
    @include('includes.js')
@stop
	
			