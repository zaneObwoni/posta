@extends('layouts.dash')

@section('content')

    
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="row">
                        <div class="col-md-6" style="margin-left:5%;" id="printableArea">
                           
                            <!--widget start-->
                            <aside class="profile-nav alt">
                                <section class="panel">
                                    <div style="padding: 2px 0 0 5%;">                                                
                                        <p>
                                            <h3 style="color:#000;">
                                                e-Njiwa VirtualPost Picking Form
                                            </h3>
                                        </p>
                                    </div>

                                    <div style="margin-left:10%">
                                        <img src="data:image/png;base64, 
                                        {!! base64_encode(QrCode::format('png')
                                        ->size(229)
                                        ->color(40,40,40)->generate($picking->stamp_code)) !!}">
                                    </div>

                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a> <i class="fa fa-tasks"></i> Full Name : <span class="pull-right"><b>{!! $picking->fullname !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Building: <span class="pull-right"><b>{!! $picking->building_name !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Street: <span class="pull-right"><b>{!! $picking->street !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Town : <span class="pull-right"><b>{!! $picking->town !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Phone : <span class="pull-right"><b>{!! $picking->phone !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Tracking Code : <span class="pull-right"><b>{!! $picking->stamp_code !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Rider : <span class="pull-right"><b>{!! $picking->rider->first_name !!}-{!! $picking->rider->last_name !!}</b></span></a></li>
                                        <li><a> <i class="fa fa-tasks"></i> Picking Charges Paid : <span class="pull-right"><b style="font-size:20px;">KShs: {!! $picking->amount!!}</b></span></a></li>
                                        <br><br>
                                        <li><a> <i class="fa fa-tasks"></i> Released By(Customer) : <span class="pull-right"><b style="font-size:20px;">________________________</b></span></a></li>
                                        <br>
                                        <li><a> <i class="fa fa-tasks"></i> Picked By(Driver/Rider) : <span class="pull-right"><b style="font-size:20px;">________________________</b></span></a></li>
                                    </ul>

                                </section>
                            </aside>
                            <!--widget end-->

                        </div>

                        <div>
                            <input type="button" onclick="printDiv('printableArea')" value="Print Receipt" />
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
			