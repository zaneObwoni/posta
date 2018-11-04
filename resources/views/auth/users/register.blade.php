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
        <b style="font-size:24px;">Welcome to Posta Virtual Box Registration</b>

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

                                    {!! Form::open(['url' => route('auth.register-post'), 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'files' => true] ) !!}
                                    {!! csrf_field() !!}

                                    <div class="form-group">
                                        {!! Form::label('first_name', 'First Name:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
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
                                        {!! Form::label('last_name', 'Last Name:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
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
                                        {!! Form::label('gender', 'Gender:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="male"> Male</option>
                                                <option value="female"> Female</option>
                                                <option value="other"> Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('dob', 'Date of Birth:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('dob', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'DD /MM /YYYY',
                                                'required',
                                                'id'                            => 'dob',
                                                'data-parsley-required-message' => 'dob is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'date',
                                                'autocomplete'                 =>"off"

                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('occupation', 'Occupation:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('occupation', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter your occupation',
                                                'required',
                                                'id'                            => 'occupation',
                                                'data-parsley-required-message' => 'occupation is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'occupation',
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
                                        {!! Form::label('identification_image', 'Upload Your ID Front (Image Only):', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::file('identification_image', null, array('class'=>'input-text full-width')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('identification_image_', 'Upload  Your ID Back (Image Only):', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::file('identification_image_', null, array('class'=>'input-text full-width')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('pin', 'KRA PIN (Optional):', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('pin', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter KRA PIN....',
                                                'id'                            => 'pin',
                                                'data-parsley-required-message' => 'identification_number is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'pin'
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
                                        {!! Form::label('town', 'Your City/Town:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::text('town', null, [
                                                'class'                         => 'form-control',
                                                'placeholder'                   => 'Enter your Town',
                                                'required',
                                                'id'                            => 'inputtown',
                                                'data-parsley-required-message' => 'town is required',
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'town'
                                            ]) !!}
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        {!! Form::label('postcode_id', 'Your Preferred Post Office:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                        <div class="col-lg-10">
                                            {!! Form::select('postcode_id', [null => 'Select your Post Code'] + $post_codes, null, [
                                                'required',
                                                'class'                         => 'form-control'
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
                                        {!! Form::label('current_email', 'Your Current Email Address:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
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
                                                'data-parsley-trigger'          => 'change focusout',
                                                'data-parsley-type'             => 'email'
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