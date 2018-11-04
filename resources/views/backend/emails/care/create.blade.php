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
                            {!! Form::model(new \App\Models\Email, ['route' => ['emails.care.store'], 'enctype' => 'multipart/form-data', 'files' => true]) !!}

                            <div class="form-group">
                                <label for="to" class="">To:</label>
                                <input type="text" tabindex="1" id="to" class="form-control" readonly="readonly" placeholder="customercare@posta.co.ke">
                            </div>
      
                            <div class="form-group">
                                <label for="subject" class="">Subject:</label>
                                <!-- <input type="text" tabindex="1" id="subject" class="form-control"> -->
                                {!! Form::text('subject', null, array('class'=>'form-control', 'placeholder'  => 'Subject', 'required')) !!}
                            </div>

                            <div class="compose-editor">
                                {!! Form::textarea('body', null, array('class'=>'wysihtml5 form-control','id'=>'body')) !!}
                                        <!-- <textarea class="wysihtml5 form-control" rows="9"></textarea> -->
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