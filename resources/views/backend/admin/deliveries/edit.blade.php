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
                
                {!! Form::model($delivery, ['route' => ['admin.deliveries.update', $delivery->getRouteKey()], '_method' => 'put', 'enctype' => 'multipart/form-data', 'files' => true]) !!}

                    <div class="form-group">
                        {!! Form::label('building_name', 'Building Name:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('building_name', null, array('class' => 'form-control', 'readonly')) !!}                                
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('street', 'Street Name:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('street', null, array('class' => 'form-control', 'readonly')) !!}                                
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('town', 'Town:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('town', null, array('class' => 'form-control', 'readonly')) !!}                                
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('phone', 'Phone:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('phone', null, array('class' => 'form-control', 'readonly')) !!}                                
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('fullname', 'Fullname Name:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('fullname', null, array('class' => 'form-control', 'readonly')) !!}                                
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('amount', 'Amount:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('amount', null, array('class' => 'form-control', 'readonly')) !!}                                
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('rider_no', 'Rider/Driver:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            <select name="rider_no" id="rider_no" class="form-control">
                                <?php
                                    foreach($riders as $rider){
                                        ?>
                                        <option value="{!! $rider->id !!}">{!! $rider->vehicle_type." - " !!}{!! $rider->first_name." " !!}{!! $rider->last_name !!}</option>
                                        <?php
                                    }
                                        
                                ?>
                            </select>
                         </div>
                    </div>

                    <div class="form-group pull-right" style="margin-right:12%;">
                        <br>
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-danger">Update Rider</button>
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