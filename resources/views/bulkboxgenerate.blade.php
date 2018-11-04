@extends('layouts.master')

@section('css')


    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="/css/adjust.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>



    <style>
        html, body {
            height: 100%;
        }

        body {
            /*     margin: 0;
                 padding: 0;
                 width: 100%;
                 display: table;
                 font-weight: 100;
                 color: #000;*/
            font-family: 'Arial';
        }

        .container {
            text-align: center;
            /*display: table-cell;*/
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
        .ui-datepicker-year{
            background-color: black;
        }
    </style>

    <script type="text/javascript">
        $(function () {
            var start = new Date();
            start.setFullYear(start.getFullYear() - 70);
            var end = new Date();
            end.setFullYear(end.getFullYear() - 18);

            $('#dob').datepicker({
                dateFormat : 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                minDate: start,
                maxDate: end,
                yearRange: start.getFullYear() + ':' + end.getFullYear()
            });
        });
    </script>
@stop
@section('content')

    @if(Session::has('message'))
        <div class="alert alert-success">
            <strong>GOOD NEWS!</strong>
            <h3>{{ Session::get('message') }}</h3>
        </div>
    @endif



    <div class="container">
        <div class="content">
            <a href="{!! route('home') !!}">
                <div class="title">
                    <div class="title">
                        <a class="logo" href="{!! route('home') !!}">
                            <img alt="" src="/images/logo.png" width="70%">
                        </a>
                    </div>
                </div>
            </a>
        </div>
        <br>
        <b style="font-size:24px;">Welcome to Virtual Box Generation</b>

        <!--main content start-->
        <section id="" class="" style="margin-top:-5%">
            <section class="wrapper">
                <!-- page start-->
                <div class="row">
                    @if (isset($errors) && $errors->any())
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="alert alert-danger alert-alt">
                                    <strong><i class="fa fa-exclamation-circle"></i> Error</strong><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <br/>
                    @endif

                    <div class="col-lg-12">
                        <section class="panel">

                            <header class="panel-heading">
                                Please Fill Details Below to start Generating.
                            </header>

                            <div class="panel-body">
                                <div class="position-center">
                                    <!-- <form class="form-horizontal" role="form"> -->

                                    {!! Form::open(['url' => route('addPostcode'), 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'files' => true] ) !!}
                                    {!! csrf_field() !!}
                                    
                                    <div class="form-group">
                                        {!! Form::label('postcode_id', 'Post Office:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::select('postcode_id', [null => 'Select Post Code'] + $post_codes, null, [
                                                'required',
                                                'class'                         => 'form-control'
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('min', 'Start From:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::number('min', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Min',
                                                'required',
                                                'id'                            => 'Min',
                                                'data-parsley-required-message' => 'Min is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'email'
                                            ]) !!}
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        {!! Form::label('max', 'Start From:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::number('max', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Max',
                                                'required',
                                                'id'                            => 'max',
                                                'data-parsley-required-message' => 'Max is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button type="submit" class="btn btn-info">Generate</button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>

                            </div>

                        </section>

                    </div>
                </div>
            </section>
        </section>
    </div>
@stop