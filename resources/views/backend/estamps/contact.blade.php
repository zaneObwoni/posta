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
                                @include('includes.errors')
                                <div style="margin-left:3%">
                                    <div style="margin-right:3%">
                                        <a href="{!! route('estamps.show.batch') !!}" class="pull-right">
                                            <button class="btn btn-default btn-primary" type="submit">
                                                <i class="fa fa-cog"></i>
                                                Show Your PIcked Letters
                                            </button>
                                        </a>
                                    </div>
                                    <div style="margin-left:3%">
                                        <a href="{!! route('auth.create-contact') !!}">
                                            <button class="btn btn-default btn-primary" type="submit">
                                                <i class="fa fa-user"></i>
                                                Add New
                                            </button>
                                        </a>
                                    </div>
                                    <br>
                                    OR


                                    Uploading from excel (<a href="/sheet1.xlsx"> View sample</a> )
                                    {!! Form::open(['url' => route('estamps.contactexcel'), 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'files' => true] ) !!}
                                    {!! csrf_field() !!}
                                    {!! Form::file('file', null, array('class'=>'input-text full-width')) !!}

                                    <br>
                                    <button type="submit" class="btn btn-danger">Upload</button>

                                    {!! Form::close() !!}


                                    <div class="row">

                                        <h4>
                                            <b>
                                                Select Contacts to Send Bulk Mail to:
                                            </b>
                                        </h4>
                                        <!-- <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%"> -->

                                        <table class="table table-striped table-bordered table-hover"
                                               id="dataTables-example">
                                            <thead>
                                            @if (Session::has('message'))
                                                <div class="alert alert-info">{{ Session::get('message') }}</div>
                                            @endif
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Phone Number</th>
                                                <th>Postal Email</th>
                                                <th>Town</th>
                                                <th>Select</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            {!! Form::open(['url' => route('estamps.bulk'), 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'files' => true] ) !!}

                                            @foreach($contact as $contacts)

                                                <tr>
                                                    <td>{!! $contacts->id !!}</td>
                                                    <td>{!! $contacts->name !!}</td>
                                                    <td>{!! $contacts->phone_number !!}</td>
                                                    <td>
                                                        {!! $contacts->posta_email !!}
                                                    </td>
                                                    <td>
                                                        {!! $contacts->town!!}
                                                    </td>
                                                    <td>

                                                        <input type="checkbox" name="check_list[]"
                                                               value="{!! $contacts->id !!}">
                                                    </td>

                                                </tr>

                                            @endforeach
                                            <tr>
                                                <td colspan="2">

                                                </td>
                                            </tr>
                                            </tbody>

                                        </table>
                                        {!! Form::select('letter_weight', ([''  => 'Select Your Letter Weight'] + $postage_rates), null, ['class' => 'form-control', 'required','style'=>'width:40%;']) !!}
                                        <div style="padding-left: 20%;padding-top: 4%;">
                                            {!! Form::submit('Submit To Proceed', ['class' => 'btn btn-warning full-width btn-large','style'=>'padding-left:5%;padding-right:5%']) !!}
                                        </div>
                                        {!! Form::close() !!}

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
	
			