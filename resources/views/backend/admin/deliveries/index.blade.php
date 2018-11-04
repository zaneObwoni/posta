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
                                        
                                        <h2>Admin Deliveries Table</h2>
                                        <!-- <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%"> -->
                                        
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Building Name</th>
                                                    <th>Street</th>                                                  
                                                    <th>Town</th>
                                                    <th>Phone</th>
                                                    <th>Full name</th>
                                                    <th>Assign a Rider</th>
                                                </tr>
                                            </thead>
                        
                                            <tbody>
                                                
                                                    @if($deliveries->count())
                                                        @foreach($deliveries as $delivery)
                                                        <tr>
                                                            <td>{!! $delivery->building_name !!}</td>
                                                            <td>{!! $delivery->street !!}</td>
                                                            <td>{!! $delivery->town !!}</td>
                                                            <td>{!! $delivery->phone !!}</td>
                                                            <td>{!! $delivery->fullname !!}</td>
                                                            <td>
                                                                @if($delivery->active == 0)
                                                                <a href="{!! route('admin.deliveries.edit', $delivery->id) !!}">
                                                                    Assign a Rider
                                                                </a>
                                                                @else
                                                                    Rider Assigned
                                                                @endif
                                                            </td>                            

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
	
			