@extends('layouts.dash')

@section('content')

    
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div style="margin-right:10%;" width="70%" class="pull-right">
                        <input type="button" onclick="printDiv('printableArea')" value="Print Report"/>
                    </div>
                    <div class="row" id="printableArea">
                        <div style="margin-left:20%;">
                            <img alt="" src="/images/logo.png">

                        </div>
                        <div class="col-md-6">
                            <div>

                            	<div style="margin-left:10%">
                            		<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(199)->color(40,40,40)->generate($picking->code)) !!}">
                            	</div>                                
                            </div>                                                    
                        </div>
                        <div class="col-md-6">
                            <div>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a> <i class="fa fa-tasks"></i> Building Name: <span class="pull-right"><b>{!! $picking->building_name !!}</b></span></a></li>
                                    <li><a> <i class="fa fa-tasks"></i> Street Name: <span class="pull-right"><b>{!! $picking->street !!}</b></span></a></li>
                                    <li><a> <i class="fa fa-tasks"></i> Picking Town : <span class="pull-right"><b>{!! $picking->town !!}</b></span></a></li>
                                    <li><a> <i class="fa fa-tasks"></i> Phone : <span class="pull-right"><b>{!! $picking->phone !!}</b></span></a></li>
                                    <li><a> <i class="fa fa-tasks"></i> Full Name : <span class="pull-right"><b>{!! $picking->fullname !!}</b></span></a></li>
                                    <li><a> <i class="fa fa-tasks"></i> Amount : <span class="pull-right"><b>KShs. {!! $picking->amount !!}</b></span></a></li>

                                        <br>
                                        <div style="margin-left:50% font-color:#000;">Rider Information</div>
                                        <li><a> <i class="fa fa-tasks"></i> Full Names: <span class="pull-right"><b>{!! $picking->rider->first_name." " !!}{!! $picking->rider->last_name !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Phone Number: <span class="pull-right"><b>{!! $picking->rider->phone !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Vehicle Type: <span class="pull-right"><b>{!! $picking->rider->vehicle_type !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Vehicle Reg. Number: <span class="pull-right"><b>{!! $picking->rider->reg_no !!}</b></span></a></li>
                                    <br>

                                        <li><a> <i class="fa fa-tasks"></i> Recipient Signature: <span class="pull-right"><b>__________________________</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Rider Signature: <span class="pull-right"><b>__________________________</b></span></a></li>
                                </ul>
                            </div>
                            <br><br><br>
                            <div><b>NOTE:</b> To be printed in triplicate.</div>
                        </div>
                    </div>
                    <br><br>
                    
                    
                </div>
            </div>
            <!--mini statistics end-->            
        </section>
    </section>
    <!--main content end-->    

@stop

@section('js')
    @include('includes.js')

    <script type="text/javascript">
        function printDiv(divName) {
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
        }
    </script>
@stop
	
			