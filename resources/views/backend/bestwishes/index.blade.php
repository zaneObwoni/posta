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
                        	<div style="margin-left:-3%">
                                <div class="pull-right">

                                    <button type="button" class="btn btn-success">
                                        <a href="{!! route('bestwishes.create') !!}">
                                            <span>Create Seasonal Greetings Stamp</span>
                                        </a>
                                    </button>
                                    &nbsp;&nbsp;

                                    <button type="button" class="btn btn-danger">
                                        <a href="{!! route('bestwishes.create','id=1') !!}">
                                            <span>Create Bulk Seasonal Greetings</span>
                                        </a>
                                    </button>
                                </div>

                                <h2>Seasonal Greetings Stamps</h2>
                                
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Stamp Code</th>
                                            <th>Receiver Name</th>
                                            <th>Season</th>                                                  
                                            <th>Recipient Town</th>
                                            <th>Recipient Email</th>
                                            <th>Price</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                
                                    <tbody>
                                        
                                            @if($estamps->count())
                                                @foreach($estamps as $estamp)
                                                <tr>
                                                    <td>{!! $estamp->code !!}</td>
                                                    <td>{!! $estamp->recipient_name !!}</td>
                                                    <td>{!! $estamp->season !!}</td>
                                                    <td>{!! $estamp->recipient_town !!}</td>
                                                    <td>{!! $estamp->recipient_email !!}</td>
                                                    <td>{!! $estamp->price !!}</td>
                                                    <td>
                                                    @if($estamp->category == 'EMS')
                                                        
                                                        <a href="/user/ems/download?code={!! $estamp->code !!}">
                                                            View EMS Stamp
                                                        </a>                                            
                                                    @else
                                                        <a href="{!! route('bestwishes.download') !!}?code={!! $estamp->code !!}">
                                                            View Stamp
                                                        </a>
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
            <!--mini statistics end-->            
        </section>
    </section>
    <!--main content end-->    

@stop

@section('js')
    @include('includes.js')
@stop
	
			