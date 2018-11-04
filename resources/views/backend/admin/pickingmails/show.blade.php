@extends('layouts.dash')

@section('content')

    
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                        <div style="font-size: 30px">
                            <b>
                                <u>
                                    Identity of Collector of Registered Mail
                                </u>
                            </b>
                        </div>
                        <br>
                        <div class="col-md-6" style="background-color: #fff;">
                            <div>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a> <i class="fa fa-tasks"></i> Name: <span class="pull-right"><b>{!! $picking->name !!}</b></span></a></li>
                                    <li><a> <i class="fa fa-tasks"></i> ID Number: <span class="pull-right"><b>{!! $picking->id_number !!}</b></span></a></li>
                                    <li><a> <i class="fa fa-tasks"></i> Phone : <span class="pull-right"><b>{!! $picking->phone !!}</b></span></a></li>
                                    <li><a> <i class="fa fa-tasks"></i> Tracking Code : <span class="pull-right"><b>{!! $picking->tracking_code !!}</b></span></a></li>
                                    <li><a> <i class="fa fa-tasks"></i> Stamp Code : <span class="pull-right"><b>{!! $picking->stamp_code !!}</b></span></a></li>
                                    <!-- <li><a> <i class="fa fa-tasks"></i> Status : <span class="pull-right"><b>{!! $picking->status !!}</b></span></a></li> -->
                                </ul>
                            </div>
                        </div>                          
                        <div>
                            <div class="col-lg-offset-2 col-lg-10">
                                <a href="{!! route('admin.main.update', $picking->tracking_code) !!}">
                                    <button type="submit" class="btn btn-danger">Confirmed</button>
                                </a>
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
	
			