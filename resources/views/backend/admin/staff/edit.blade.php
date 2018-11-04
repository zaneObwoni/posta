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
   
                <h2>Staff Edit</h2>
                <div class="row">

                    {!! Form::model($mainUser, ['route' => ['admin.staff.update', $mainUser->getRouteKey()], '_method' => 'put', 'enctype' => 'multipart/form-data', 'files' => true]) !!}

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

                    <!-- <div class="form-group">
                        {!! Form::label('city', 'City:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('city', null, array('class' => 'form-control')) !!}
                        </div>
                    </div> -->

                    <div class="form-group">
                        {!! Form::label('employee_no', 'Employee Number:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('employee_no', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        {!! Form::label('vehicle_type', 'Vehicle Type:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('vehicle_type', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('reg_no', 'Registration No:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('reg_no', null, array('class' => 'form-control')) !!}
                        </div>
                    </div> -->

                    <br>
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