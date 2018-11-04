@extends('layouts.dash')

@section('css')
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>js">
@stop

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
                
                {!! Form::model(new \App\Models\PickingMail, ['route' => ['admin.mail.store']]) !!}
                    <div class="form-group">
                        {!! Form::label('reference_code', 'Enter Reference Code:', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                        <div class="col-lg-10">
                            {!! Form::text('reference_code', null, array('class' => 'form-control')) !!}                                
                        </div>
                    </div>

                    <div class="form-group pull-right" style="margin-right:12%;">
                        <br>
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-danger">Collect Picker Details</button>
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

<script>
        $('#rider_no').change(function () {

            alert(here);

            $.get('staff_rider/' + this.value + '/postboxes.json', function (postboxes) {
                var $staff = $('#staff');

                $staff.find('option').remove().end();

                $.each(postboxes, function (index, postbox) {
                    $staff.append('<option value="' + postbox.employee_no + '">' + postbox.employee_no + '</option>');
                });
            });
        });
    </script>

    
@stop