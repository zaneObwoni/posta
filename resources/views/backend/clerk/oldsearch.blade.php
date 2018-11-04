@extends('layouts.dash')

@section('css')
    <style type="text/css">

        .lefty {
            padding-right: 3%;
        }

        .border {
            height: 140px;
            width: 40%;
            border: 2px solid grey;
        }

        .box {
            margin: 1px 0 0 2.8%;
            color: #000;
            font-size: 16px;
            background-color: #fff;
            width: 80%;
            padding: 2%
        }

        .header-top {
            width: 45px;
            margin-top: -13px;
            margin-left: 5px;
            background: white;
        }

        .btn {
            width: 95px;
        }
    </style>
@stop
{{--{!! dd($estamp->price) !!}--}}
@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="row">
                        <div class="col-md-12">

                            @if(Session::has('message'))
                                <div class="alert-box success">
                                    <h4>{{ Session::get('message') }}</h4>
                                </div>
                            @endif

                            <div style="margin-left: -3%; padding: 2%; width: 100%;">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <div>
                                            {{-- {!! Form::open(['method'=>'GET','url'=>'user/clerk/search','class'=>'navbar-form navbar-left','role'=>'search'])  !!} --}}


                                            {!! Form::open(['method'=>'POST', 'url' => route('clerk.search-estamp-post'), 'class' => 'form-horizontal','role'=>'search'] ) !!}
                                            <div class="input-group custom-search-form">
                                                <input type="text" class="form-control" name="search" id="search_id"
                                                       placeholder="Search..." style="width: 655px;">
                                                <span class="input-group-btn">
                                                        <button class="btn btn-success" type="submit" id="btnSearch">Search!</button>
                                                    </span>
                                            </div>
                                            {!! Form::close() !!}
                                        </div
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                @if($estamp == "NULL")

                                @elseif($estamp == "NOT FOUND")

                                    <div style="margin-left: 3%">
                                        <div style="margin-right:60%">
                                            <div>
                                                <div class="alert alert-danger">
                                                    <strong>Error!</strong> Stamp Code not Found
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="box">
                                        <div class="pull-right" style="margin-right:60%">
                                            <div>{!! $estamp->code !!}</div>
                                            <div>{!! $estamp->recipient_name !!}</div>
                                            <div>P.O Box: {!! $estamp->destination_box !!}
                                                -{!! $estamp->destination_code !!}</div>
                                            <div>{!! $estamp->destination_town !!}</div>
                                            <div>{!! $estamp->destination_box !!}
                                                -{!! $estamp->destination_code !!}@posta.co.ke
                                            </div>
                                        </div>
                                        <div>
                                            <span class="lefty">Tracking Code:</span> <br>
                                            <span class="lefty">Name:</span> <br>
                                            <span class="lefty">Address:</span> <br>
                                            <span class="lefty">Town:</span> <br>
                                            <span class="lefty">Email:</span> <br>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="box">
                                        <div class="border pull-right">
                                            <div class="header-top">Parcel</div>
                                            <div style="padding: 2%; padding-left:15%; margin-top:15px;">
                                                <a href="">
                                                    <button type="button" class="btn btn-info" onclick="postData(2,'/app/parcel/')">Sender</button>
                                                </a>
                                                <a href="">
                                                    <button type="button" class="btn btn-info" onclick="postData(1,'/app/parcel/')">Receiver</button>
                                                </a>
                                            </div>

                                            <div style="padding: 2%;  padding-left:15%; margin-top:5px;">
                                                <a href="">
                                                    <button type="button" class="btn btn-info" onclick="postData(5,'/api/v1/rts/parcel/create/')">Expired</button>
                                                </a>
                                                <a href="">
                                                    <button type="button" class="btn btn-info" onclick="underPaid(7,'/api/v1/rts/parcel/create/')">Underpaid</button>
                                                </a>
                                            </div>
                                        </div>


                                        <div class="border">
                                            <div class="header-top">Letter</div>
                                            <div style="padding: 2%; padding-left:15%; margin-top:15px;">
<<<<<<< HEAD:resources/views/backend/clerk/oldsearch.blade.php
                                                <button type="button" onclick="postData(1)" class="btn btn-info">Eric</button>
                                                <button type="button" class="btn btn-info">Receiver</button>
                                            </div>

                                            <div style="padding: 2%;  padding-left:15%; margin-top:5px;">
                                                    <button type="button" class="btn btn-info">Expired</button>
                                                    <button type="button" class="btn btn-info">Underpaid</button>
=======


                                                <button type="button" onclick="postData(2,'/app/')" class="btn btn-info">Sender
                                                </button>


                                                <button type="button" class="btn btn-info" onclick="postData(1,'/app/')">Receiver</button>

                                            </div>

                                            <div style="padding: 2%;  padding-left:15%; margin-top:5px;">
                                                <a href="">
                                                    <button type="button" class="btn btn-info" onclick="postData(5,'/api/v1/rts/create/')">Expired</button>
                                                </a>
                                                <a href="">
                                                    <button type="button" class="btn btn-info" onclick="underPaid(7,'/api/v1/underpayment/create/')">Underpaid</button>
                                                </a>
>>>>>>> c125064f486b846b73b97f353732ea52798c1bea:resources/views/backend/clerk/search.blade.php
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="box">
                                        <!-- <div class="border pull-right">
                                            <div class="header-top">Parcel</div>
                                            <div style="padding: 2%; padding-left:15%; margin-top:15px;">
                                                <button type="button" class="btn btn-info">Sender</button>
                                                <button type="button" class="btn btn-info">Receiver</button>
                                                
                                            </div>

                                            <div style="padding: 2%;  padding-left:15%; margin-top:5px;">
                                                <button type="button" class="btn btn-info">Expired</button>
                                                <button type="button" class="btn btn-info">Underpaid</button>
                                            </div>
                                        </div> -->

                                        <div class="border">
                                            <div class="header-top">EMS</div>
                                            <div style="padding: 2%; padding-left:15%; margin-top:15px;">
                                                <button type="button" class="btn btn-info" onclick="postData(2,'/app/ems/')">Sender</button>
                                                <button type="button" class="btn btn-info" onclick="postData(1,'/app/ems/')">Receiver</button>

                                            </div>

                                            <div style="padding: 2%;  padding-left:15%; margin-top:5px;">
                                                <button type="button" class="btn btn-info" onclick="postData(5,'/app/ems/')">Expired</button>
                                                <button type="button" class="btn btn-info" onclick="underPaid(5,'/app/ems/')" id="underPaid">Underpaid</button>
                                            </div>
                                        </div>
                                    </div>

                                @endif
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

<<<<<<< HEAD:resources/views/backend/clerk/oldsearch.blade.php
<<<<<<< HEAD
    <script>
    function show(){
        $(document).ready(
                function() {
                    setInterval(function() {
                        var randomnumber = Math.floor(Math.random() * 100);
                        $('#show').text(
                                'I am getting refreshed every 3 seconds..! Random Number ==> '
                                        + randomnumber);
                    }, 3000);
                });
    }
=======
=======
<?php
if (isset($estamp->code))
{
>>>>>>> c125064f486b846b73b97f353732ea52798c1bea:resources/views/backend/clerk/search.blade.php

        ?>
    <script type="text/javascript">


        function underPaid(tag,stringUrl) {
            var stamp_price = "<?php echo $estamp->price?>";

            var amount = prompt("Please enter Actual Stamp price", 0);
            var amount = parseInt(amount);

            stamp_price=parseInt(stamp_price);
            if (amount != null) {

                var balance=(amount-stamp_price);

                var stamp_code = "<?php echo $estamp->code?>";
                var display2 = {};
                display2["tag"] = tag;
                display2["code"] = stamp_code;
                display2["balance"] = balance;
                display2["price"] = amount;
                display2["user_id"] = "<?php echo $user->id?>";
                display2["station_code"] = "<?php echo $user->postcode_id?>";
                info = [];
                info[0] = display2;
                //alert(JSON.stringify(info));


                $.ajax({
                    type: "POST",
                    url: stringUrl + JSON.stringify(info)
                    // data: info
                })
                        .done(function (msg) {
                            alert('Success Notification sent!');
//                            if(msg=='0')
//                            {
//                                alert("The stamp has been used!" );
//                            }

                        });

//                $.ajax({
//                    url: stringUrl + JSON.stringify(info)
//                    // data: info
//                })
//                        .done(function (msg) {
//                            alert("Data Saved: " + msg);
//                        });
            }


        }

        function postData(tag,stringUrl) {



            var stamp_code = "<?php echo $estamp->code;?>"

           // alert(stamp_code);

            var display2 = {};
            display2["tag"] = tag;
            display2["code"] = stamp_code;
            display2["user_id"] = "<?php echo $user->id;?>";
            display2["station_code"] = "<?php echo $user->postcode_id;?>";
            info = [];
            info[0] = display2;
            //alert(JSON.stringify(info));
//                                                        alert("Hello");
            //var code = $('#code').val();
//                                                        alert(code);
            $.ajax({
                url: stringUrl + JSON.stringify(info)
                // data: info
            })
                    .done(function (msg) {
                        if(msg=='0')
                        {
                            alert("The stamp has been used!" );
                        }

                    });
        }
>>>>>>> 9773c1d5392a5ac5624e6c1405d349d17d8943a4
    </script>
<?php
}
?>
@stop