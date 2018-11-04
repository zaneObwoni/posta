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
                            <div class="timeline-messages">

                                @if(Session::has('message'))
                                    <div class="alert-box success">
                                        <h4>{{ Session::get('message') }}</h4>
                                    </div>
                                @endif

                                            <div style="margin-left:10%">
                                                <div class="row">
                                                    <div class="col-lg-9">
                                                        <section class="panel">

                                                            <header class="panel-heading">
                                                                My Picking/Delivery Information
                                                            </header>
                                                            <div class="panel-body">
                                                                {!! Form::model(new \App\Models\Picking, ['route' => ['pickings.save']]) !!}
                                                                @include('backend.pickings._formPicking_Delivery', ['submitButtonText' => 'Create Picking/Delivery'])
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </section>
                                                    </div>
                                                </div>
                                            </div>
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
    </script>

 @stop