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
                        <h4 class="gen-case"> Compose Mail
                            <form action="#" class="pull-right mail-src-position">
                                <div class="input-append">
                                    <input type="text" class="form-control " placeholder="Search Mail">
                                </div>
                            </form>
                        </h4>
                    </header>
                    <div class="panel-body">
                        @include('includes.errors')

                        <div class="compose-mail">
                            {!! Form::model(new \App\Models\Email, ['route' => ['emails.store'],'enctype' => 'multipart/form-data', 'files' => true]) !!}

                            <div class="form-group">
                                <label for="to" class="">To:</label>
                                <!-- <input type="text" tabindex="1" id="to" class="form-control"> -->
                                {!! Form::text('to', null, array('class'=>'form-control', 'placeholder'  => 'Type email to', 'required')) !!}
                            </div>
                            <div class="form-group">
                                <label for="cc" class="">CC:</label>
                                <!-- <input type="text" tabindex="1" id="to" class="form-control"> -->
                                {!! Form::text('cc', null, array('class'=>'form-control', 'placeholder'  => 'Type email to cc')) !!}
                            </div>
                            <div class="form-group">
                                <label for="bcc" class="">Bcc:</label>
                                <!-- <input type="text" tabindex="1" id="to" class="form-control"> -->
                                {!! Form::text('bcc', null, array('class'=>'form-control', 'placeholder'  => 'Type email to bcc')) !!}
                            </div>

                            <div class="form-group">
                                <label for="subject" class="">Subject:</label>
                                <!-- <input type="text" tabindex="1" id="subject" class="form-control"> -->
                                {!! Form::text('subject', null, array('class'=>'form-control', 'placeholder'  => 'Subject', 'required')) !!}
                            </div>
                            <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>

                            <div class="">
                                {!! Form::textarea('body', null, array('class'=>'form-control','id'=>'body')) !!}
                                        <!-- <textarea class="wysihtml5 form-control" rows="9"></textarea> -->
                            </div>
                            <script>
                                CKEDITOR.env.isCompatible = true;
                                CKEDITOR.replace( 'body' );
//                                config.removeDialogTabs = 'flash:advanced;image:Link';
                            </script>
                            
                            <div class="form-group">
                                {!! Form::label('file_attachment', 'Attach File:', array('class' => 'col-lg-2 col-sm-2 control-label', 'style'=>'width:40%')) !!}
                                <div class="col-lg-10">
                                    {!! Form::file('file_attachment', null, array('class'=>'input-text full-width')) !!}
                                </div>
                            </div>

                            <br>
                            <div class="compose-btn pull-right">
                                <button class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Send</button>
                            </div>

                            {!! Form::close() !!}
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