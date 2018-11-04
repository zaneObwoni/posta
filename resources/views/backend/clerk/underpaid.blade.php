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
                        	<div style="margin-left:-5%">
                        		<div class="row">
                                    
                                    <h3>Underpaid Estamps</h3>
                                    
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Stamp Code</th>
                                                <th>Amount</th>
                                                <th>Postal Code</th>                                                  
                                                <th>Status</th>
                                                <th>Active</th>
                                            </tr>
                                        </thead>
                    
                                        <tbody>
                                            
                                                @if($estamps->count())
                                                    @foreach($estamps as $estamp)
                                                    <tr>
                                                        <td>{!! $estamp->stamp_code !!}</td>
                                                        <td>{!! $estamp->amount !!}</td>
                                                        <td>{!! $estamp->postal_code !!}</td>
                                                        <td>{!! $estamp->status !!}</td>
                                                        <td>
                                                        @if($estamp->active == 1)
                                                            YES                                           
                                                        @else
                                                            NO
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
	
			