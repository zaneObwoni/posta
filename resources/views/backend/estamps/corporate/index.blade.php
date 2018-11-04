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
                        	<div style="margin-left:-4%">
                        		<div class="row">
                                    
                                    <h4>
                                        <div class="pull-right" style="margin-right:2%">
                                            <a href="{!! route('estamps.corporate.batch') !!}">
                                                Batch Estamps
                                            </a>
                                        </div>
                                        <b>
                                            List of Corporate E-Stamps so far Purchased
                                        </b>
                                    </h4>
                                    
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Stamp Code</th>
                                                <th>Receiver Name</th>
                                                <th>To</th>                                                  
                                                <th>Town</th>
                                                <th>Recipient Phone</th>
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
                                                        <td>{!! $estamp->destination_box !!}-{!! $estamp->destination_code !!}</td>
                                                        <td>{!! $estamp->destination_town !!}</td>
                                                        <td>{!! $estamp->recipient_phone !!}</td>
                                                        <td>{!! $estamp->price !!}</td>
                                                        <td>
                                                               

                                                            @if($estamp->category == 'EMS')
                                                                <a href="/user/ems/download?code={!! $estamp->code !!}">
                                                                    View EMS Stamp
                                                                </a>                                            
                                                            @else
                                                                <a href="/user/bulk/download?unique_number={!! $estamp->unique_number !!}">
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
            </div>
            <!--mini statistics end-->            
        </section>
    </section>
    <!--main content end-->    

@stop

@section('js')
    @include('includes.js')
@stop
	
			