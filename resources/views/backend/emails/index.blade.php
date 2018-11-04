@extends('layouts.dash')

@section('content')

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!-- page start-->
            <div class="row">
                @include('backend.emails.side')

                <div class="col-sm-9">
                    <section class="panel">
                        <header class="panel-heading wht-bg">
                            <h4 class="gen-case">Inbox ({!! $notifications_emails !!})
                                <!-- <form action="#" class="pull-right mail-src-position">
                                    <div class="input-append">
                                        <input type="text" class="form-control " placeholder="Search Mail">
                                    </div>
                                </form> -->
                            </h4>
                        </header>
                        <div class="panel-body minimal">
                            <!-- <div class="mail-option">
                                <div class="chk-all">
                                    <div>All</div>
                                </div>

                                <ul class="unstyled inbox-pagination">
                                    <li><span>1-50 of 124</span></li>
                                    <li>
                                        <a class="np-btn" href="#"><i class="fa fa-angle-left  pagination-left"></i></a>
                                    </li>
                                    <li>
                                        <a class="np-btn" href="#"><i class="fa fa-angle-right pagination-right"></i></a>
                                    </li>
                                </ul>
                            </div> -->
                            <div class="table-inbox-wrap ">
                                <table class="table table-inbox table-hover">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Sender Name</th>
                                        <th>Sender Email Address</th>
                                        <th>Email Subject</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($emails->count())
                                        @foreach($emails as $email)

                                            <tr class="unread">
                                                <td class="inbox-small-cells"><i class="fa fa-star"></i></td>

                                                <td class="view-message  dont-show">
                                                    <a href="{!! route('emails.show', $email->id) !!}">
                                                        {!! DB::table('users')->where('email', $email->from)->value('first_name') !!}
                                                        {!! DB::table('users')->where('email', $email->from)->value('last_name') !!}
                                                    </a>
                                                </td>
                                                <td class="view-message ">{!! $email->from !!}</td>
                                                <td class="view-message  dont-show"><a
                                                            href="{!! route('emails.show', $email->id) !!}">{!! $email->subject !!}</a>
                                                </td>
                                                @if($email->file_attachment>0)
                                                    <td class="view-message  inbox-small-cells"><i
                                                                class="fa fa-paperclip"></i></td>
                                                @else
                                                    <td class="view-message  inbox-small-cells"><i class=""></i></td>
                                                @endif
                                                <td class="view-message  text-right">{!! $email->created_at !!}</td>
                                            </tr>

                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <!-- page end-->
        </section>
    </section>
    <!--main content end-->

@stop