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
				            
				            <div class="col-lg-9" style="text-align:center;">
				                <section>

									<h2>Your Payment was successful.</h2>
									
									<h3>Thank You for purchasing the Stamp for Postage.</h3>


									<br>
									<h3>
										@if(!empty($_GET['code']))
											<a href="{!! route('registers.download', 'code='.$_GET['code']) !!}">Download and Print your Stamp</a>											
										@else
											<a href="{!! route('registers.download') !!}">Download and Print your Stamp</a>
										@endif
									</h3>

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
	
			