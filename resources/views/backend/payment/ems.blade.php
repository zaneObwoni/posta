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

				            	{!! $code = DB::table('estamps')->where('id', $_GET['code'])->value('code');!!}
				                <section>

									<h2>Your Payment was successful.</h2>
									
									<h3>Thank You for purchasing your EMS Stamp for Postage.</h3>


									<br>
									<h3>
										@if(!empty($code))
											<a href="{!! route('ems.download', 'code='.$code) !!}">Download and Print your Stamp</a>											
										@else
											<a href="{!! route('ems.download') !!}">Download and Print your Stamp</a>
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
	
			