{{--beginning of section scripts--}}
<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<link href="/css/adjust.css" rel="stylesheet" type="text/css">
{{--end of script section--}}

@include('includes.errors')
<div class="form-group">
    {!! Form::label('code', 'Item Code:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('code', null, array('class'=>'form-control', 'placeholder'=>'Enter item code received','id'=>'code','name'=>'code','autocomplete'=>"off")) !!}
    </div>
</div>
<br>
<br>
<br>
<div class="form-group">
    {!! Form::label('amount', 'Balance Amount (Ksh):', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::number('amount', null, array('class'=>'form-control','placeholder'=>'Amount e.g 1100', 'required')) !!}

    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('sender_phone', 'Phone No:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        <h5><b>{!!$user->phone !!}</b></h5>
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('sender_name', 'Name:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        <h5><b>{!! $user->first_name.' '.$user->last_name !!}</b></h5>
    </div>
</div>


<br>
<br>

<div class="form-group row">
    <div class="col-sm-6 col-md-5">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success full-width btn-large']) !!}
        or &nbsp; <a href="{{ route('deliveries.index') }}" class="soap-popupbox">Cancel</a>
    </div>
</div>

