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
                                        
                                        <h2>Corporates Table</h2>
                                        <!-- <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%"> -->
                                        
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Corporation Name</th>
                                                    <th>Address</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Certificate Number</th>
                                                    <th>Town</th>
                                                </tr>
                                            </thead>
                        
                                            <tbody>
                                                
                                                    @if($users->count())
                                                        @foreach($users as $user)
                                                        <tr>
                                                            <td>{!! $user->first_name !!}</td>
                                                            <td>{!! $user->last_name !!}</td>
                                                            <td>{!! $user->email !!}</td>
                                                            <td>{!! $user->phone !!}</td>
                                                            <td>{!! $user->identification_number !!}</td>
                                                            <td>{!! $user->town !!}</td>
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
	
			