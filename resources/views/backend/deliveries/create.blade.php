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
                            @if(!empty($delivery))
                                @if($delivery==1)


                                    <div style="margin-left:10%">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <section class="panel">

                                                    <header class="panel-heading">
                                                        My delivery Information
                                                    </header>
                                                    <div class="panel-body">
                                                        {!! Form::model(new \App\Models\Delivery, ['route' => ['deliveries.store']]) !!}
                                                        @include('backend.deliveries._form', ['submitButtonText' => 'Create Delivery'])
                                                        {!! Form::close() !!}
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>

                                @else
                                    <div style="margin-left:10%">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <section class="panel">

                                                    <header class="panel-heading">
                                                        My delivery Information
                                                    </header>
                                                    <div class="panel-body">
                                                        {!! Form::model(new \App\Models\Delivery, ['route' => ['deliveries.store']]) !!}
                                                        @include('backend.deliveries._form_ems', ['submitButtonText' => 'Create Delivery'])
                                                        {!! Form::close() !!}
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else



                                <div style="margin-left:10%">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <section class="panel">

                                                <header class="panel-heading">
                                                    My delivery Option (Normal Or EMS)
                                                </header>
                                                <div class="panel-body">
                                                    {!! Form::model(new \App\Models\Delivery, ['route' => ['deliveries.store'],'enctype' => 'multipart/form-data']) !!}
                                                    @include('backend.deliveries._form_deliverytype', ['submitButtonText' => 'Next >>'])
                                                    {!! Form::close() !!}
                                                </div>
                                            </section>
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

    <script>
        function show() {
            $(document).ready(
                    function () {
                        setInterval(function () {
                            var randomnumber = Math.floor(Math.random() * 100);
                            $('#show').text(
                                    'I am getting refreshed every 3 seconds..! Random Number ==> '
                                    + randomnumber);
                        }, 3000);
                    });
        }
    </script>

@stop