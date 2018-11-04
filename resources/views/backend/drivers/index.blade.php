@extends('layouts.dash')


@section('css')
    <link rel="stylesheet" href="/css/datatables.min.css">

    <style type="text/css">
        
        .button_green{
            background-color: green;
            color: green;
        }

        .button_red{
            background-color: red;
            color: red;
        }
    </style>
@stop

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="col-md-12">
                    	<div style="margin-left:-2%">
                    		<div class="row">
                                @if(!Auth::User()->isPMG())                                                    
                                    <div class="pull-right">                                    
                                        <button type="button" class="btn btn-primary">
                                            <a href="{!! route('admin.create') !!}">
                                                <span>Add Driver</span>
                                            </a>
                                        </button>
                                    </div>
                                @endif

                                <h2>Drivers</h2>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Driver Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Employee Number</th>
                                            <th>Town</th>
                                            <th>Vehicle Type</th>
                                            <th>Registration No</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                
                                    <tbody>
                                        
                                        @if($users->count())
                                            @foreach($users as $user)
                                            <tr>
                                                <td>{!! $user->first_name." " !!}{!! $user->last_name !!}</td>
                                                
                                                <td>{!! $user->email !!}</td>
                                                <td>{!! $user->phone !!}</td>
                                                <td>{!! $user->employee_no !!}</td>
                                                <td>{!! $user->city !!}</td>
                                                <td>{!! $user->vehicle_type !!}</td>
                                                <td>{!! $user->reg_no !!}</td>
                                                <td>
                                                     @if($user->status == 0)
                                                     
                                                        <button class="button_green">
                                                            <div style="color: #fff;">Driver Available</div>                                        
                                                        </button>      
                                                    @else
                                                        <button class="button_red">
                                                            <div style="color: #fff;">
                                                                Driver Assigned
                                                            </div>
                                                        </button>
                                                    
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        
                                    </tbody>
                                </table>

                            </div>
                    	</div>
                    </div>
                </div>
            </div>
            <!--mini statistics end-->            
        </section>
    </section>
    <!--main content end-->    

@stop

@section('js')
    @include('includes.js')
@stop
	
			