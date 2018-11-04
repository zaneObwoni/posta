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

                            @if($estamp->category == "EMS")
                                <div id="printableArea" class="print">
                                    <div style="margin-left:5%">
                                        <img src="data:image/png;base64, 
                                        {!! base64_encode(QrCode::format('png')
                                        ->size(299)
                                        ->color(40,40,40)->generate($estamp->code)) !!}">
                                    </div>
                            

                                    <br/>
                                    <div style="margin-left:17%; font-size:20px;">Code: <b>{!! $estamp->code !!}</b></div>
                                    <div style="margin-left:23%; font-size:22px;"><b>KENYA - {!! $estamp->price !!}/-</b></div>

                                    <br><br>
                                    <div style="margin-left:10%; font-size:18px;"><b>Description:</b> {!! $picking->sub_category !!}</div>
                                    <div style="margin-left:10%; font-size:18px;"><b>Extra Weight(Kgs):</b> {!! $picking->extra_weight !!}</div>

                                    <div style="margin:-49% 20% 0 45%; font-size:17px;">
                                        <br>
                                        <div><b>Sender Details</b></div>
                                        <div>{!! $estamp->sender_name !!}</div>
                                        <div>{!! $estamp->sender_phone !!}</div>
                                        <div>{!! $picking->building_name !!}</div>
                                        <div>{!! $picking->street !!}</div>
                                        <div>{!! $picking->town !!}</div>       

                                        <br>
                                        <div></div>
                                        <div><b>Receiver Details</b></div>
                                        <div>{!! $estamp->recipient_name !!}</div>
                                        <div>{!! $estamp->recipient_phone !!}</div>
                                        <div>{!! $picking->d_building_name !!}</div>
                                        <div>{!! $picking->d_street !!}</div>
                                        <div>{!! $picking->d_town !!}</div>                         
                                    </div>
                                </div>

                                @else
                                
                                <div id="printableArea">
                                    <div style="margin-left:10%">
                                        <img src="data:image/png;base64, 
                                        {!! base64_encode(QrCode::format('png')
                                        ->size(229)
                                        ->color(40,40,40)->generate($estamp->code)) !!}">
                                    </div>

                                    <br/>
                                    <div style="margin-left:17%; font-size:20px;">Code: <b>{!! $estamp->code !!}</b></div>
                                    <div style="margin-left:23%; font-size:18px;"><b>KENYA - {!! $estamp->price !!}/-</b></div>

                                    <div style="margin:-32% 20% 0 45%; font-size:16px;">
                                        <!-- <br>
                                        <div>{!! $estamp->recipient_name !!}</div>
                                        <div>Box: {!! $estamp->destination_box !!}-{!! $estamp->destination_code !!}</div>
                                        <div>{!! $estamp->destination_town !!}</div>                              
                                        <div>Email: {!! DB::table('users')->where('phone', $estamp->recipient_phone)->value('email') !!}</div>

 -->
                                        <br>
                                        <div><b>Sender Details</b></div>
                                        <div>{!! $estamp->sender_name !!}</div>
                                        <div>{!! $estamp->sender_phone !!}</div>
                                        <div>Email: {!! DB::table('users')->where('phone', $estamp->sender_phone)->value('email') !!}</div>     

                                        <br>
                                        <div><b>Receiver Details</b></div>
                                        <div>{!! $estamp->recipient_name !!}</div>
                                        <div>Box: {!! $estamp->destination_box !!}-{!! $estamp->destination_code !!}</div>
                                        <div>Email: {!! $estamp->destination_box !!}-{!! $estamp->destination_code !!}@posta.co.ke</div>
                                        <div>Town: {!! $estamp->destination_town !!}</div>
                                                            
                                    </div>
                                </div>

                            @endif

                            <div style="margin:-6% 10%;" class="pull-right">
                                <input type="button" onclick="printDiv('printableArea')" value="Print your Stamp" />
                            </div>

                            <br>
                            <div style="margin-left:5%; margin-top:13%; text-align:center;">
                                <h4>
                                    Right Click on the E-Stamp Image above to Save to your Computer/Phone. <br>

                                    <br>
                                    You may Print it to stick on your Envelope for Postage.
                                    <br>

                                    <br>
                                    <b>
                                        Would you like us to pick your Letter/Parcel? <a href="{!! route('pickings.create', $estamp->code) !!}">Click here</a>
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
	
			