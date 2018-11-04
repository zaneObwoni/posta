@extends('layouts.dash')

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="timeline-messages">
                            	<div style="margin-left:3%">
                            		<div class="row">
                                        
                                        <h2>My Registered Mail Table</h2>
                                        
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Receiver Name</th>
                                                    <th>Box</th>                                                  
                                                    <th>Town</th>
                                                    <th>Recipient Phone</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                        
                                            <tbody>
                                                
                                                    @if($registers->count())
                                                        @foreach($registers as $registered)
                                                        <tr>
                                                            <td>{!! $registered->recipient_name !!}</td>
                                                            <td>{!! $registered->destination_box !!}-{!! $registered->destination_code !!}</td>
                                                            <td>{!! $registered->destination_town !!}</td>
                                                            <td>{!! $registered->recipient_phone !!}</td>
                                                            <td>{!! $registered->price !!}</td>

                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                
                                            </tbody>
                                        </table>

                                    </div>
                            	</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--mini statistics end-->            
        </section>
    </section>
    <!--main content end-->    

@stop

@section('js')
    @include('includes.js')
@stop
	
			