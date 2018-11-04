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
                                        
                                        <h2>Admin pickings Table</h2>
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
                                                
                                                    @if($pickings->count())
                                                        @foreach($pickings as $picking)
                                                        <tr>
                                                            <td>{!! $picking->building_name !!}</td>
                                                            <td>{!! $picking->street !!}</td>
                                                            <td>{!! $picking->town !!}</td>
                                                            <td>{!! $picking->phone !!}</td>
                                                            <td>{!! $picking->fullname !!}</td>
                                                                                                        
                                                            @if($picking->active == 0)
                                                            <td><a href="{!! route('admin.pickings.edit', $picking->id) !!}">Assign a Rider</a></td>
                                                            @else
                                                                <td>Rider Assigned</td>
                                                            @endif
                                                            
                                                            <!-- <td>
                                                                @if($picking->rider_no != 1)
                                                                    <a href="{!! route('admin.pickings.show', $picking->id) !!}">See Code</a>    
                                                                @else
                                                                    None
                                                                @endif
                                                            </td> -->

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
	
			