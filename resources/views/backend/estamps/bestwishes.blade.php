
 <!DOCTYPE html>
@extends('layouts.dash')



@section('content')
    <script>
        window.onload = function () {
            qr_canvasf();
        };
    </script>

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="row">


                        @if($estamp == null)
                            <h4>
                            You do not have an E-Stamp Yet.
                            Please create an E-Stamp first. 
                            </h4>
                        @else
                        <div class="col-md-12">

                            <div id="printableArea" hidden>
                                <div style="margin-left:10%">
                                    <img id="scream" src="data:image/png;base64,
                                        {!! base64_encode(QrCode::format('png')
                                        ->size(229)
                                        ->color(40,40,40)->generate($estamp->code)) !!}">
                                </div>

                                <br/>
                                <div style="margin-left:17%; font-size:20px;">Code: <b>{!! $estamp->code !!}</b></div>
                                <div style="margin-left:23%; font-size:18px;"><b>KENYA - {!! $estamp->price !!}/-</b>
                                </div>

                                <div style="margin:-32% 20% 0 45%; font-size:16px;">

                                    <br>
                                    <br>
                                    <div><b>Receiver Details</b></div>
                                    <div>{!! $estamp->recipient_name !!}</div>
                                    <div>Box: {!! $estamp->destination_box !!}-{!! $estamp->destination_code !!}</div>
                                    <div>Email: {!! $estamp->destination_box !!}-{!! $estamp->destination_code !!}@posta
                                        .co.ke
                                    </div>
                                    <div>Town: {!! $estamp->destination_town !!}</div>

                                </div>
                            </div>

                            <div style="margin:-6% 10%;" class="pull-right">
                                <input type="button" onclick="printDiv('printableArea')" value="Print your Stamp"/>
                            </div>


                            <canvas id="qr_canvas" width="800" height="240"
                                    style="border:1px solid #d3d3d3; background-color: #ffffff;">
                                You cannot print estamp from this browser please contact admin
                            </canvas>

                            <p>
                                <button onclick="printCanvas()">Print Your Estamp</button>
                                OR ( Right click and save to print later)
                            </p>
                            <?php

                            $amount = $estamp->price;
                            $name = $estamp->recipient_name;
                            $box=$estamp->destination_box.'-'.$estamp->destination_code;
                            $town = $estamp->destination_town;
                            $code = $estamp->code;
                            $email = $estamp->destination_box.'-'.$estamp->destination_code.'@posta.co.ke';
                            $message = ' Dear '. $estamp->recipient_name.', Posta joins '. $estamp->sender_name.' in wishing you success in your Exams.';

                            ?>
                            <script>
                                function qr_canvasf() {

                                    var c = document.getElementById("qr_canvas");

                                    var ctx = c.getContext("2d");

                                    var img = document.getElementById("scream");
                                    ctx.drawImage(img, 10, -20, 200, 200);


                                    var c = document.getElementById("qr_canvas");
                                    var ctx = c.getContext("2d");
                                    var x = 230;
                                    ctx.font = "bold 18px Arial";
                                    ctx.fillText("<?php echo $name; ?>", x, 60);
                                    ctx.fillText("P.O Box   : <?php echo $box; ?>", x, 85);
                                    ctx.fillText("<?php echo $town; ?>", x, 110);
                                    ctx.fillText("EMAIL : <?php echo $email; ?>", x, 135);

                                    ctx.fillText("KENYA", 30, 180);
                                    ctx.fillText("<?php echo $amount; ?> /=", 150, 180);
                                    ctx.fillText("CODE  : <?php echo $code; ?>", 30, 200);
                                    ctx.font = "bold 18px Arial";
                                    ctx.fillText("<?php echo $message; ?> ", 30, 225);

                    





                                    document.getElementById("qr_canvas").style.backgroundColor = 'rgba(255, 255, 255, 100%)';

                                }
                            </script>

                            <div style="margin-left:5%; margin-top:5%; text-align:center;">
                                <h4>
                                    Right Click on the E-Stamp Image above to Save to your Computer/Phone. <br>

                                    <br>
                                    You may Print it to stick on your Envelope for Postage.
                                    <br>

                                    <br>
                                    <b>
                                        Would you like us to pick your Letter/Parcel? <a
                                                href="{!! route('pickings.create', $estamp->code) !!}">Click here</a>
                                    </b>
                                </h4>
                            </div>
                        </div>
                        @endif
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
        function printCanvas() {
            var dataUrl = document.getElementById('qr_canvas').toDataURL(); //attempt to save base64 string to server using this var
            var windowContent = '<!DOCTYPE html>';
            windowContent += '<html>'
            windowContent += '<head><title>www.posta.co.ke</title></head>';
            windowContent += '<body>'
            windowContent += '<img src="' + dataUrl + '">';
            windowContent += '</body>';
            windowContent += '</html>';
            var printWin = window.open('', '', 'width=1200,height=500');
            printWin.document.open();
            printWin.document.write(windowContent);
            printWin.document.close();
            printWin.focus();
            printWin.print();
            printWin.close();
        }
    </script>
@stop


