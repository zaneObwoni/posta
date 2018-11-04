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
				            {!! $code = DB::table('estamps')->where('id', $_GET['code'])->value('code'); !!}
				            <div class="col-lg-9" style="text-align:center;">
				            	@if(Auth::User()->isUser())
					                @if(DB::table('estamps')->where('code', $code)->value('category') == 'SEASON')
				            			<section>
											<h2>Your Payment was successful.</h2>
											<h3>Thank You for purchasing the E-Stamp for Postage.</h3>
											<br>
											<h3>
												<a href="{!! route('season.download', 'code='.$code) !!}">Download and Print your E-Stamp</a>
											</h3>

										</section>
									@elseif(DB::table('estamps')->where('code', $code)->value('category') == 'REGISTERED')
				            			<section>
											<h2>Your Payment was successful.</h2>
											<h3>Thank You for purchasing the E-Stamp for Postage.</h3>
											<br>
											<h3>
												<a href="{!! route('registers.download', 'code='.$code) !!}">Download and Print your E-Stamp</a>
											</h3>

										</section>
									@else
						                <section>

											<h2>Your Payment was successful.</h2>										
											<h3>Thank You for purchasing the E-Stamp for Postage.</h3>
											<br>
											<h3>
												<a href="{!! route('estamp.download', 'code='.$code) !!}">Download and Print your E-Stamp</a>
											</h3>
										</section>
									@endif
								@endif

								@if(Auth::User()->isAgent())
					                <section>

										<h2>Your Payment was successful.</h2>
										
										<h3>Thank You for purchasing the E-Stamp for Postage.</h3>


										<br>
										<h3>
											<a href="{!! route('estamp.download', 'code='.$code) !!}">Download and Print your E-Stamp</a>
										</h3>

									</section>
								@endif


								@if(Auth::User()->isCorporate())
									<section>
										
										<h2>Your Payment was successful.</h2>
										
										<h3>Thank You for purchasing the E-Stamps for Postage.</h3>


										<br>
										@if($category == 'EMS')
											<h3>
												<a href="{!! route('estamp.download', 'code='.$code) !!}">See your EMS Estamp Here</a>
											</h3>
										@else
											<h3>
												<a href="{!! route('estamp.download') !!}">See your Bulk Estamps Here</a>
											</h3>
										@endif

									</section>
								@endif

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
	
			