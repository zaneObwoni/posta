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

                            <div id="printableArea">
                                <div style="margin-left:10%">
                                    <img src="data:image/png;base64, 
                                    {!! base64_encode(QrCode::format('png')
                                    ->size(299)
                                    ->color(40,40,40)->generate( 
                                    "Batch Number: ".$batch_number.
                                    "\nCodes: ".$codes.
                                    "\nFrom: ".$from.
                                    "\nTo: ".$to)) !!}">
                                </div>

                                <br/>
                                <!-- <div style="margin-left:17%; font-size:20px;">Batch Number: <b>{!! $batch_number !!}</b></div> -->

                                <div style="margin:-29% 20% 0 45%; font-size:22px;">
                                    <br>
                                    <div><b>Batch Number:</b> {!! $batch_number!!}</div>
                                    <div><b>From:</b> {!! $from !!}</div>                              
                                    <div><b>To:</b> {!! $to !!}</div>
                                </div>
                            </div>

                            <div style="margin:7% 12%;" class="pull-right">
                                <input type="button" onclick="printDiv('printableArea')" value="Print your Stamp" />
                            </div>

                            <br>
                            <div style="margin-left:5%; margin-top:18%; text-align:center;">
                                <h4>
                                    Right Click on the E-Stamp Image above to Save to your Computer/Phone. <br>

                                    <br>
                                    You may Print it to stick on your Envelope for Postage.
                                    <br>

                                    <br>
                                    <b>
                                        Would you like us to pick your Letter/Parcel? <a href="{!! route('pickings.create', $batch_number) !!}">Click here</a>
                                    </b>
                                </h4>
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
	
			