@extends('layouts.dash')

@section('content')

    
    <!--main content start-->
    <section id="main-content" style="margin-bottom:70px;">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="row">
                        <div class="col-md-12">

                            
                            <div class="pull-right" style="margin-right:10%">
                                @if(!empty($batch_number = DB::table('estamps')->where('unique_number', $_GET['unique_number'])->value('batch_number')))
                                <a href="{!! route('batch.create', $batch_number) !!}">
                                    <button type="button" class="btn btn-info">Batch Stamps</button>
                                </a>
                                @endif
                            </div>

                            

                            @if($estamps->count())
                                @foreach($estamps as $estamp)

                                        <div style="margin-left:10%">
                                            <img src="data:image/png;base64, 
                                            {!! base64_encode(QrCode::format('png')
                                            ->size(219)
                                            ->color(40,40,40)->generate($estamp->code)) !!}" style="padding-top:15%">
                                        </div>
                                    

                                        <br/>
                                        <div style="margin-left:17%; font-size:15px;">Code: <b>{!! $estamp->code !!}</b></div>
                                        <div style="margin-left:23%; font-size:15px;"><b>KENYA - {!! $estamp->price !!}/-</b></div>

                                        <div style="margin:-32% 20% 0 45%; font-size:16px;">
                                        
                                            <br>
                                            <div><b>Sender Details</b></div>
                                            <div>{!! $estamp->sender_name !!}</div>
                                            <div>{!! $estamp->sender_phone !!}</div>
                                            <div>{!! $estamp->origin_town !!}</div>
                                            <div>{!! DB::table('users')->where('phone', $estamp->recipient_phone)->value('email') !!}</div>      

                                            <br>
                                            <div></div>
                                            <div><b>Receiver Details</b></div>
                                            <div>{!! $estamp->recipient_name !!}</div>
                                            <div>{!! $estamp->recipient_phone !!}</div>
                                            <div>{!! $estamp->destination_town !!}</div>
                                            <div>To: {!! $estamp->destination_box !!}-{!! $estamp->destination_code !!}</div>
                                            <br>
                                            <div class="pull-right">
                                                <a href="{!! route('estamps.view', $estamp->id) !!}">View and Print your Stamp</a>
                                            </div>
                                        </div>

                                    <br>

                                @endforeach
                            @endif

         
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
    
            