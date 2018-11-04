@include('includes.errors')


<div class="form-group">
    {!! Form::label('sender_phone', 'Sender Phone No:', array('class'=>'col-sm-3 control-label')) !!}                        
    <div class="col-sm-6">
        <h5><b>{!! $senderPhone !!}</b></h5>
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('sender_name', 'Sender Names:', array('class'=>'col-sm-3 control-label')) !!}                        
    <div class="col-sm-6">
        <h5><b>{!! $senderName !!}</b></h5>
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('season', 'Season Card:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('season', (['0'  => 'Select Your Season Card'] + $seasons), null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('recipient_town', 'Recipient Town:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('recipient_town', null, array('class' => 'form-control') !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('letter_weight', 'Letter Weight & Cost:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('letter_weight', null, ['class' => 'form-control']) !!}
    
    </div>
</div>
<br>
<br>

<div class="form-group">
    {!! Form::label('message', 'Message:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('message', null, array('class'=>'form-control', 'placeholder'=>'ie. Wishing you a Happy Birthday')) !!}
    </div>
</div>
<br>
<br>

<div class="form-group row">
    <div class="col-sm-6 col-md-5">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success full-width btn-large']) !!}
        or &nbsp; <a href="{{ route('estamps.index') }}" class="soap-popupbox">Cancel</a>
    </div>
</div>

