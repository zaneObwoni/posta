@extends('layouts.dash')

@section('css')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style type="text/css">

        .lefty{
            padding-right: 3%;
        }

        .border{
            height:140px;
            width:40%;
            border:2px solid grey;
        }

        .box{
            margin: 1px 0 0 2.8%;
            color:#000;font-size:16px;
            background-color: #fff;
            width: 80%;
            padding: 2%
        }

        .header-top{
            width:45px;
            margin-top:-13px;
            margin-left:5px;
            background:white;
        }

        .btn{
            width: 95px;
        }
    </style>
@stop

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
                                        <h2>
                                            <div>Send a Letter Scanner</div>
                                        </h2>
                                        <br>
                                        <div>
                                            <div class="input-group custom-search-form">
                                                <input type="text" class="form-control" name="search" id="searchField" placeholder="Search..." style="width: 655px;" oninput="submitdata()">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-success" onclick="submitdata" id="btnSearch">Search!</button>
                                                </span>
                                            </div>
                                        </div
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <!-- // Add not found here -->

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
    
    <script type="text/javascript">
    function submitdata()
    {
         var value = $("#searchField").val();
         if(value.length>= 3){
            ajax_search(value);
         }

    }
        
        

        function ajax_search(value){
            //alert(value);

            var display2 = {};
            display2["tag"] = 2;
            display2["code"] = value;
            display2["user_id"] = "<?php echo $user->id;?>";
            display2["station_code"] = "<?php echo $user->postcode_id;?>";
            info = [];
            info[0] = display2;
           // alert(JSON.stringify(info));
//                                                        alert("Hello");
            //var code = $('#code').val();
//                                                        alert(code);
            $.ajax({
                url: '/app/' + JSON.stringify(info)
                // data: info
            })
                    .done(function (msg) {
                        if(msg=='0')
                        {
                            alert("The stamp has been used!" );
                        }

                    });
        
          
    }
    </script>
@stop