@extends('layouts.dash')

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!--mini statistics start-->
            <div class="row">
                <div id="job-history" class="tab-pane ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="timeline-messages">
                            	<div style="margin-left:3%">
                            		<div class="row">

                                        <h2>Our {!! $user_tittle->name !!}</h2>

                                        <!-- <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%"> -->

                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>

                                                <tr>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Employee Number</th>
                                                    <th>Branch</th>
                                                    <th>ID Number</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                            @if (($users>0))
                                                        @foreach($users as $user)
                                                        <tr>
                                                            <td>{!! $user->first_name !!}</td>
                                                            <td>{!! $user->last_name !!}</td>
                                                            <td>{!! $user->email !!}</td>
                                                            <td>{!! $user->phone !!}</td>
                                                            <td>{!! $user->employee_no !!}</td>
                                                            <td>{!! $user->postcode_id !!}</td>
                                                            <td>{!! $user->identification_number !!}</td>
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

