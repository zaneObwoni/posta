@extends('layouts.dash')

@section('css')
    
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href="/css/adjust.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>js"></script>
@stop

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            
            <!--mini statistics start-->
            <div class="col-md-12">
                <div class="col-md-9" style="margin-left: 20%">
                    @if(Session::has('messages'))
                        <div class="alert alert-success">
                            <strong>Success!</strong><h3>{{ Session::get('messages') }}</h3>
                        </div>
                    @endif
                </div>
            </div>
            <!--mini statistics end-->        

        </section>
    </section>
    <!--main content end-->
    

@stop