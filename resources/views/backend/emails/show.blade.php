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
                        <h4 class="gen-case"> View Message
                            <!-- <form action="#" class="pull-right mail-src-position">
                                <div class="input-append">
                                    <input type="text" class="form-control " placeholder="Search Mail">
                                </div>
                            </form> -->
                        </h4>
                    </header>
                    <div class="panel-body ">

                        <div class="mail-header row">
                            <div class="col-md-8">
                                <h4 class="pull-left">
                                    {!! $email->title !!}
                                </h4>
                            </div>
                            <div class="col-md-4">
                                <div class="compose-btn pull-right">
                                    <a href="{!! route('emails.create') !!}" class="btn btn-sm btn-primary"><i
                                                class="fa fa-reply"></i> Reply</a>
                                </div>
                            </div>

                        </div>
                        <div class="mail-sender">
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- <strong>ThemeBucket</strong> -->
                                        <span>
                                            <b>
                                                {!! DB::table('users')->where('email', $email->from)->value('first_name') !!}
                                                {!! DB::table('users')->where('email', $email->from)->value('last_name') !!}
                                            </b>
                                        </span>
                                    to
                                    <strong>me</strong>
                                    @if($cc_recipient)
                                        cc
                                        <b>{!! $cc_recipient !!}</b>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <p class="date"> {!! $email->created_at !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="view-mail">
                            <p>

                                {!! $email->body  !!}
                            </p>

                            @if($email->file_attachment == 'NULL')
                                
                            @else
                                <a style="float:right"
                                   href="{!! url('/').'/uploads/mail_attach/'.$email->file_attachment !!}"
                                   download
                                   target="_blank">Download Attachment
                                </a>
                            @endif
                        </div>


                        <br><br>
                        <div class=" compose-btn pull-left">
                            <a href="{!! route('emails.create') !!}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-reply"></i> Reply</a>
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