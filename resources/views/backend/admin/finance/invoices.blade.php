@extends('layouts.dash')

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="col-md-12">
                    	<div style="margin-left:-3%">
                    		<div class="row">
                                
                                <h2>Finance Invoices</h2>
                                
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <!-- <th>Purchase Number</th> -->
                                            
                                            <th>Corporate Customer</th>
                                            <th>View</th>
                                            <!-- <th>Date</th>                                                     -->
                                        </tr>
                                    </thead>
                
                                    <tbody>
                                        
                                        @if($invoices->count())
                                            @foreach($invoices as $invoice)
                                            <tr>
                                                
                                                <td>
                                                    {!! DB::table('users')->where('id', $invoice->corporate_id)->value('first_name'); !!}
                                                </td>
                                                <td>
                                                    <a href="{!! route('finance.customer', $invoice->corporate_id) !!}">
                                                        View this Corporate Financials
                                                    </a>
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
	
			