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
                                    {!! $user->first_name." " !!}{!! $user->last_name !!}
                                    <a href="{!! route('user.edit', $user->id) !!}">
                                        <div class="pull-right">Edit</div>
                                    </a>
                                </h3>

                                <div style="margin-left:5%;">
                                    <img src="/uploads/user/{!! $user->pic !!}">
                                </div>
                                @if(Auth::User()->isCorporate())
                                <!-- Comment -->
                                <div class="msg-time-chat">
                                    <div class="message-body msg-in">
                                        <span class="arrow"></span>
                                        <div class="text">
                                            <div class="first">
                                                Company Name
                                            </div>
                                            <div class="second bg-terques ">
                                                {!! $user->first_name !!}
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
                                                Physical Address
                                            </div>
                                            <div class="second bg-red">
                                                {!! $user->last_name !!}
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
                                                {!! $user->phone !!}
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
                                                Town
                                            </div>
                                            <div class="second bg-yellow">
                                                {!! $user->town !!}
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
                                                {!! $user->email !!}
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
                                                Certificate Reg. No
                                            </div>
                                            <div class="second bg-green">
                                                {!! $user->identification_number !!}
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
                                                Postal Box
                                            </div>
                                            <div class="second bg-red">
                                                {!! $user->postbox_id !!}
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
                                                Postal Code
                                            </div>
                                            <div class="second bg-purple">
                                                {!! $user->postcode_id !!}
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
                                                Alternative Email Address
                                            </div>
                                            <div class="second bg-green">
                                                {!! $user->current_email !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                        <!-- Comment -->
                                <div class="msg-time-chat">
                                    <div class="message-body msg-in">
                                        <span class="arrow"></span>
                                        <div class="text">
                                            <div class="first">
                                                First Name
                                            </div>
                                            <div class="second bg-terques ">
                                                {!! $user->first_name !!}
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
                                                {!! $user->last_name !!}
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
                                                {!! $user->phone !!}
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
                                                Town
                                            </div>
                                            <div class="second bg-yellow">
                                                {!! $user->town !!}
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
                                                {!! $user->email !!}
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
                                                Identification Number
                                            </div>
                                            <div class="second bg-green">
                                                {!! $user->identification_number !!}
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
                                                Postal Box
                                            </div>
                                            <div class="second bg-red">
                                                {!! $user->postbox_id !!}
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
                                                Postal Code
                                            </div>
                                            <div class="second bg-purple">
                                                {!! $user->postcode_id !!}
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
                                                Current Email Address
                                            </div>
                                            <div class="second bg-green">
                                                {!! $user->current_email !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
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
                                                @if($user->active == 1)
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