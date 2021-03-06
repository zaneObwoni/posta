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
                                <div class="pull-right">Edit</div>                                
                                <h3>
                                    {!! $mainUser->first_name." " !!}{!! $mainUser->last_name !!}
                                    <a href="{!! route('admin.staff.edit', $mainUser->id) !!}">
                                        <div class="pull-right">Edit</div>
                                    </a>
                                </h3>

                                        <!-- Comment -->
                                <div class="msg-time-chat">
                                    <div class="message-body msg-in">
                                        <span class="arrow"></span>
                                        <div class="text">
                                            <div class="first">
                                                First Name
                                            </div>
                                            <div class="second bg-terques ">
                                                {!! $mainUser->first_name !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /comment -->

                                <!-- Comment -->
                                <div class="msg-time-chat">
                                    <div class="message-body msg-in">
                                        <span class="arrow"></span>
                                        <div class="text">
                                            <div class="first">
                                                Last Name
                                            </div>
                                            <div class="second bg-red">
                                                {!! $mainUser->last_name !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /comment -->

                                <!-- Comment -->
                                <div class="msg-time-chat">
                                    <div class="message-body msg-in">
                                        <span class="arrow"></span>
                                        <div class="text">
                                            <div class="first">
                                                Phone
                                            </div>
                                            <div class="second bg-green">
                                                {!! $mainUser->phone !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /comment -->
                               
                                <!-- Comment -->
                                <div class="msg-time-chat">
                                    <div class="message-body msg-in">
                                        <span class="arrow"></span>
                                        <div class="text">
                                            <div class="first">
                                                Email
                                            </div>
                                            <div class="second bg-blue">
                                                {!! $mainUser->email !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /comment -->

                                <!-- Comment -->
                                <div class="msg-time-chat">
                                    <div class="message-body msg-in">
                                        <span class="arrow"></span>
                                        <div class="text">
                                            <div class="first">
                                                Employee Number
                                            </div>
                                            <div class="second bg-red">
                                                {!! $mainUser->employee_no !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /comment -->

                                <!-- Comment -->
                                <div class="msg-time-chat">
                                    <div class="message-body msg-in">
                                        <span class="arrow"></span>
                                        <div class="text">
                                            <div class="first">
                                                Status
                                            </div>
                                            <div class="second bg-yellow">
                                                @if($mainUser->active == 1)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /comment -->
                               
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