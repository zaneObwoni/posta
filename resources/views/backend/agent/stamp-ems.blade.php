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




                        <div class="col-md-12">

                            <div id="printableArea" hidden>
                                <div style="margin-left:10%">
                                    <img id="scream" src="data:image/png;base64,
                                        {!! base64_encode(QrCode::format('png')
                                        ->size(1200)
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

                            <div style="margin-right: 23%;" class="pull-right">
                                <button type="button" class="btn btn-info">

                                    <a href="{!! route('normal.edit.location', $estamp->code) !!}">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        Click here to Redirect this Letter
                                    </a>
                                </button>
                            </div>

                            <canvas id="qr_canvas" width="800" height="300"
                                    style="border:1px solid #d3d3d3; background-color: #ffffff;">
                                You cannot print estamp from this browser please contact admin
                            </canvas>

                            <p>
                                <button onclick="printCanvas()">Print Your Estamp</button>
                                OR ( Right click and save to print later)
                            </p>
                            <?php

                            $amount = $estamp->price;
                            $name = $estamp->sender_name;
                            $box=$estamp->destination_box.'-'.$estamp->destination_code;
                            $town_sender = $picking->building_name.', '.$picking->street.', '.$picking->town;
                            $code = $estamp->code;
                            $email = DB::table('users')->where('phone', $estamp->sender_phone)->value('email');
                            $message = $picking->sub_category;;

                            //receiver details
                            $name_receiver = $estamp->recipient_name;
                            //$box_sender=$estamp->destination_box.'-'.$estamp->destination_code;
                            $town_receiver = $picking->d_building_name.', '. $picking->d_street.', '.$picking->d_town;
                            // $email_receiver = $user->email;
                            $email_receiver= DB::table('users')->where('phone', $estamp->recipient_phone)->value('email');
                            $extra_weight=$picking->extra_weight;
                            ?>
                            <script>
                                function qr_canvasf() {

                                    var c = document.getElementById("qr_canvas");

                                    var ctx = c.getContext("2d");

                                    var img = document.getElementById("scream");
                                    ctx.drawImage(img, 10, -20, 200, 200);


                                    var c = document.getElementById("qr_canvas");
                                    var ctx = c.getContext("2d");
                                    var x = 250;
                                    var y = 40;
                                    //Sender details
                                    ctx.font = "bold 18px Arial";
                                    ctx.fillText("<?php echo "SENDER DETAILS"; ?>", x, y);
                                    y=y+25;
                                    ctx.font = "16px Arial";
                                    ctx.fillText("<?php echo $name; ?>", x, y);
                                    y=y+25;
                                    ctx.fillText("<?php echo $town_sender; ?>", x,y);
                                    y=y+25;
                                    ctx.fillText("<?php echo $email; ?>", x, y);

                                    ctx.font = "bold 18px Arial";


                                    y=y+35;
                                    ctx.fillText("<?php echo "RECEIVER DETAILS"; ?>", x, y);
                                    y=y+25;
                                    ctx.font = "16px Arial";
                                    ctx.fillText("<?php echo $name_receiver; ?>", x, y);
                                    y=y+25;
                                    ctx.fillText("<?php echo $town_receiver ; ?>", x,y);
                                    y=y+25;
                                    ctx.fillText("<?php echo $email_receiver; ?>", x, y);
                                    y=y+35;


                                    ctx.fillText("KENYA", 30, 180);
                                    ctx.fillText("<?php echo $amount; ?> /=", 150, 180);
                                    ctx.fillText("CODE  : <?php echo $code; ?>", 30, 200);
                                    ctx.font = "bold 18px Arial";

                                    ctx.fillText("Description: ", 30, 250);
                                    ctx.fillText("<?php echo $message; ?>", 150, 250);
                                    ctx.fillText("Extra Weight: ", 30, 275);
                                    ctx.fillText("<?php echo $extra_weight; ?> ", 150, 275);

                                    document.getElementById("qr_canvas").style.backgroundColor = 'rgba(255, 255, 255, 100%)';
                                }
                            </script>
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
        function printCanvas() {
            var dataUrl = document.getElementById('qr_canvas').toDataURL(); //attempt to save base64 string to server using this var
            var windowContent = '<!DOCTYPE html>';
            windowContent += '<html>';
            windowContent += '<head><title>www.posta.co.ke</title></head>';
            windowContent += '<body>';
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


