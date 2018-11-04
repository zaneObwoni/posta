@extends('layouts.dash')

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->

            @if(Session::has('message'))
                <div class="alert alert-danger">
                    <strong>Error!</strong><h3>{{ Session::get('message') }}</h3>
                </div>
            @endif

            @include('includes.errors')
   
                <div class="row">

                    {!! Form::model($mainUser, ['route' => ['admin.user.update', $mainUser->getRouteKey()], '_method' => 'put', 'enctype' => 'multipart/form-data', 'files' => true]) !!}

                    <div class="form-group">
                        {!! Form::label('first_name', 'First Name:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('first_name', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>


                    <div class="form-group">
                        {!! Form::label('last_name', 'Last Name:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('last_name', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('email', 'Email:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::email('email', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('phone', 'Phone:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('phone', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('town', 'City/Town:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('town', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        {!! Form::label('county_id', 'County:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::select('county_id', (['0' => 'Select a location'] + $counties), $selectedCounty, ['class' => 'form-control']) !!}
                        </div>
                    </div> -->

                    <div class="form-group">
                        {!! Form::label('identification_number', 'National Id:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('identification_number', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('postbox_id', 'Post Box:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('postbox_id', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('postcode_id', 'Post Code:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('postcode_id', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('current_email', 'Alternative Email:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::email('current_email', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

       

                    <br><br>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-danger">Update User</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            <!--mini statistics end-->        
        </section>
    </section>
    <!--main content end-->
    

@stop

@section('js')
    @include('includes.js')
@stop