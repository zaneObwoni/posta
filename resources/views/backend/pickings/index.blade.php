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
                                        
                                        <h4>
                                            <b>
                                                List of Pickings so far Requested:
                                            </b>
                                        </h4>

                                        @if(Session::has('message'))
                                            <div class="alert alert-success">
                                                <strong>Success!</strong>{{ Session::get('message') }}
                                            </div>
                                        @endif

                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Stamp Code</th>
                                                    <th>Building Name</th>
                                                    <th>Street</th>
                                                    <th>Town</th>
                                                    <th>Phone</th>
                                                    <th>Full Name</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                        
                                            <tbody>
                                                
                                                    @if($pickings->count())
                                                        @foreach($pickings as $picking)
                                                        <tr>
                                                            <td>{!! $picking->stamp_code !!}</td>
                                                            <td>{!! $picking->building_name !!}</td>
                                                            <td>{!! $picking->street !!}</td>
                                                            <td>{!! $picking->town !!}</td>
                                                            <td>{!! $picking->phone !!}</td>
                                                            <td>{!! $picking->fullname !!}</td>
                                                            <td>{!! $picking->amount !!}</td>

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
	
			