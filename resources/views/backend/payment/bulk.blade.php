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
									
									<h3>Thank You for purchasing your Bulk E-Stamps for Postage.</h3>


									<br>
										<h3>
											<a href="{!! route('bulk.download', 'unique_number='.$_GET['trans_id']) !!}">See your Bulk Estamp Here</a>
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
	
			