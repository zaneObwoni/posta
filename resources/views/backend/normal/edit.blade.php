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

                {!! Form::model($estamp, ['route' => ['normal.update.location', $estamp->getRouteKey()], '_method' => 'put']) !!}

                    <div class="form-group">
                        {!! Form::label('code', 'Code:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('code', null, array('class' => 'form-control', 'readonly')) !!}                                
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        {!! Form::label('', 'Postal Box:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-3">
                            {!! Form::text('destination_box', null, array('class' => 'form-control')) !!}                      
                        </div>
                        <div class="col-lg-3">
                            {!! Form::text('destination_code', null, array('class' => 'form-control')) !!}                                
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        {!! Form::label('destination_town', 'Location Name:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('destination_town', null, array('class' => 'form-control')) !!}                                
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-danger">Update Location</button>
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