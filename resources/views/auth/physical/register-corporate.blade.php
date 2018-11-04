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

@stop

@section('content')

    @if(Session::has('message'))
        <div class="alert alert-danger">
            <strong>Error!</strong>
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
        <b style="font-size:30px;">
            Register your Physical Box for Virtual Post Services (Corporate)
        </b>

        <!--main content start-->
        <section id="" class="" style="margin-top:-5%">
            <section class="wrapper">
                <!-- page start-->
                <div class="row">
                    @include('includes.errors')

                    <div class="col-lg-12">
                        <section class="panel">

                            <header class="panel-heading">
                                Please Fill in your Details Below.
                            </header>

                            <div class="panel-body">
                                <div class="position-center">
                                    <!-- <form class="form-horizontal" role="form"> -->

                                    {!! Form::open(['url' => route('physical.corporate.register-post'), 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'files' => true] ) !!}
                                    {!! csrf_field() !!}

                                    <div class="form-group">
                                        {!! Form::label('first_name', 'Company Name:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('first_name', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter your First Name',
                                                'required',
                                                'id'                            => 'inputfirstName',
                                                'data-parsley-required-message' => 'First Name is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'first_name',
                                                'autocomplete'                 =>"off"

                                            ]) !!}            
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        {!! Form::label('last_name', 'Company Physical Address*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('last_name', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter your Last Name',
                                                'required',
                                                'id'                            => 'inputlast_name',
                                                'data-parsley-required-message' => 'last_name is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'last_name',
                                                'autocomplete'                 =>"off"

                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('phone', 'Phone:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('phone', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter your Phone',
                                                'required',
                                                'id'                            => 'inputphone',
                                                'data-parsley-required-message' => 'phone is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'phone',
                                                'autocomplete'                 =>"off"

                                            ]) !!}
                                        </div>
                                        <div id="phone_error" class="alert alert-danger"  style="display:none; visibility: hidden;"></div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('identification_number', 'Your National ID Number:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('identification_number', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter your National Id Number',
                                                'required',
                                                'id'                            => 'inputidentification_number',
                                                'data-parsley-required-message' => 'identification_number is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'identification_number',
                                                'autocomplete'                 =>"off"

                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('password', 'Password:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::password('password', [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter Password',
                                                'required',
                                                'id'                            => 'inputPassword',
                                                'data-parsley-required-message' => 'Password is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-minlength'        => '2',
                                                'data-parsley-maxlength'        => '20',
                                                'autocomplete'                 =>"off"
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('confirm_password', 'Confirm Password:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::password('confirm_password', [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter Password Confirmation',
                                                'required',
                                                'id'                            => 'inputPassword',
                                                'data-parsley-required-message' => 'Password is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-minlength'        => '2',
                                                'data-parsley-maxlength'        => '20',
                                                'autocomplete'                 =>"off"
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('county_id', 'Your County:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::select('county_id', [null => 'Select your County'] + $counties, null, [
                                                'required',
                                                'class'                         => 'form-control'
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('postbox', 'Your Current Box Number:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::number('postbox', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter your Postbox without Postcode. eg. 56342',
                                                'required',
                                                'id'                            => 'inputpostbox',
                                                'min'                           => '0', 
                                                'data-parsley-required-message' => 'postbox is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'postbox'
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('postcode', 'Your Current Post Code:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::number('postcode', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter your Postcode only. eg. 00100',
                                                'required',
                                                'id'                            => 'inputpostcode',
                                                'min'                           => '0',
                                                'data-parsley-required-message' => 'postcode is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'postcode'
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('town', 'Your City/Town:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('town', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter your Town',
                                                'required',
                                                'id'                            => 'inputtown',
                                                'data-parsley-required-message' => 'town is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'town',
                                                'autocomplete'                 =>"off"

                                            ]) !!}
                                        </div>
                                    </div>

                                    <div>
                                        Please, note that by filing this Form and registering for a Virtual Post Office Box, you accept also to receive free SMS status updates regarding your Box, Letters, Parcels and Other services provided by Posta.
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button type="submit" class="btn btn-danger">Register</button>
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