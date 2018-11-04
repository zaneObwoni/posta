@extends('layouts.master')

@section('css')

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="/css/adjust.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <style>
        html, body {
            height: 100%;
        }

        /*body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            color: #000;
            font-family: 'Lato', sans-serif;
        }*/

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
                        <a class="logo" href="#">
                            <img alt="" src="/images/logo.png">
                        </a>
                    </div>
                </div>
            </a>
        </div>

        <!--main content start-->
        <section id="" class="">
            <section class="wrapper">
                <!-- page start-->
                <div class="row">

                    @include('includes.errors')

                    <div class="col-lg-12">
                        <section class="panel">
                            <b style="font-size:30px;">Welcome to Posta Virtual Box Registration (Corporate)</b>
                            <header class="panel-heading">
                                Please Fill Corporate Details below.
                            </header>

                            <div class="panel-body">
                                <div class="position-center">

                                    {!! Form::open(['url' => route('auth.corporate-post'), 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'files' => true] ) !!}
                                    {!! csrf_field() !!}

                                    <div class="form-group">
                                        {!! Form::label('first_name', 'Company Name:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('first_name', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Company Name',
                                                'required',
                                                'id'                            => 'inputfirstName',
                                                'data-parsley-required-message' => 'Corporate Name is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'first_name',
                                                'autocomplete'                 =>"off"

                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('last_name', 'Company physical Address:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('last_name', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => ' Enter Corporate Physical Address',
                                                'required',
                                                'id'                            => 'inputlast_name',
                                                'data-parsley-required-message' => 'last_name is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'last_name',
                                                'autocomplete'                 =>"off"

                                            ]) !!}
                                        </div>
                                    </div>

                                    <div style="margin-left:8%">
                                        <b>
                                            Use Safaricom line ONLY since payment is by M-PESA.
                                        </b>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('phone', 'Mobile Phone:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('phone', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter Corporate Mobile Phone',
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
                                        {!! Form::label('county_id', 'Your County:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::select('county_id', (['0'  => 'Select your County'] + $counties), null, [
                                                'class'                         => 'form-control',
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

                                    <div class="form-group">
                                        {!! Form::label('postcode_id', 'Your Preferred Post Office:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::select('postcode_id', [null => 'Select your Post Code'] + $post_codes, null, [
                                                'required',
                                                'class'     => 'form-control'
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('postbox_id', 'Your Preferred Box Number:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            <select name="postbox_id" id="postbox_id" class="form-control" required>
                                                <option selected value="">
                                                    Select Your Preferred Box Number after the Post Code
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('director_name', 'Director Name:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('director_name', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter Director name',
                                                'required',
                                                'id'                            => 'director_name',
                                                'data-parsley-required-message' => 'director_name is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'director_name',
                                                'autocomplete'                 =>"off"

                                            ]) !!}
                                        </div>
                                    </div>




                                    <div class="form-group">
                                        {!! Form::label('director_id', 'Director ID:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('director_id', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter Director ID',
                                                'required',
                                                'id'                            => 'director_id',
                                                'data-parsley-required-message' => 'director_id is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'director_id',
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
                                                'data-parsley-maxlength'        => '20'
                                            ]) !!}
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('identification_number', 'Registration Certificate No:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('identification_number', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter Certificate of Registration No.',
                                                'required',
                                                'id'                            => 'inputidentification_number',
                                                'data-parsley-required-message' => 'identification_number is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'identification_number'

                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('pdf_certificate', 'Upload Certificate:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::file('pdf_certificate', null, array('class'=>'input-text full-width')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('pin', 'Company PIN:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('pin', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter Corporation KRA PIN',
                                                'required',
                                                'id'                            => 'pin',
                                                'data-parsley-required-message' => 'identification_number is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'pin'
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('identification_image', 'Upload PIN:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::file('identification_image', null, array('class'=>'input-text full-width')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('current_email', 'Alternative Email:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::email('current_email', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter Email Address',
                                                'required',
                                                'id'                            => 'inputCurrrentEmail',
                                                'data-parsley-required-message' => 'Email is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'email'
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div style="margin-left: 15%">
                                            <b>
                                                Recruiting Agent Section. Leave blank if you are not a POSTA Agent.
                                            </b>
                                        </div>
                                        {!! Form::label('agent_phone', 'Introduced by(Agent):', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('agent_phone', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Agent Phone Number. ie. 0712345455',
                                                'id'                            => 'inputCurrrentEmail',
                                                'data-parsley-required-message' => 'Agent is required',
                                                'data-parsley-trigger'          => 'change focusout'
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div>
                                        Please, note that by filing this Form and registering for a Virtual Post Office Box, you accept also to receive free SMS status updates regarding your Box, Letters, Parcels and Other services provided by Posta.
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button type="submit" class="btn btn-danger">Register</button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>

                            <script>
                                $('#postcode_id').change(function () {


                                    $.get('register_postcode/' + this.value + '/postboxes.json', function (postboxes) {
                                        var $postbox_id = $('#postbox_id');

                                        $postbox_id.find('option').remove().end();

                                        $.each(postboxes, function (index, postbox) {
                                            $postbox_id.append('<option value="' + postbox.number + '">' + postbox.number + '</option>');
                                        });
                                    });
                                });

                                $('#inputphone').change(function(){

                                    //var phone =this.value
                                    var digit = (''+this.value )[1];
                                    if(digit==0)
                                    {
                                        document.getElementById('phone_error').style.visibility='visible';
                                        document.getElementById('phone_error').style.display='inline';
                                        document.getElementById('phone_error').innerHTML="<br><br>You must enter a correct Phone number e.g 0710xxxx";
                                        //alert('You must enter a correct Phone number' );
                                        this.value='';
                                    }
                                    else {
                                        document.getElementById('phone_error').style.visibility='hidden';
                                        document.getElementById('phone_error').style.display='none';
                                    }

                                });

                            </script>

                        </section>

                    </div>
                </div>
            </section>
        </section>
    </div>
@stop