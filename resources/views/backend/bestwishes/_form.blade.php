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
    {!! Form::label('origin_town', 'Origin Town:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::select('origin_town', (['0'  => 'Select Your Origin Town'] + $towns), null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('season', 'Season Card:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::select('season', (['0'  => 'Select Your Season Card'] + $seasons), null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>
<br>
<br>

<div class="form-group">
    {!! Form::label('recipient_name', 'Recipient Name:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('recipient_name', null, array('class'=>'form-control', 'placeholder'=>'ie. John Otieno')) !!}                                        
    </div>
</div>
<br>
<br>

<div class="form-group">
    {!! Form::label('recipient_phone', 'Recipient Phone No:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('recipient_phone', null, array('class'=>'form-control', 'placeholder'=>'ie. +254765623348')) !!}
    </div>
</div>
<br>
<br>

<div class="form-group">
    {!! Form::label('recipient_box', 'Recipient Box No:', array('class'=>'col-sm-3 control-label')) !!}                        
    <div class="col-sm-6">
        {!! Form::text('recipient_box', null, array('class'=>'form-control', 'placeholder'=>'ie. 5623348')) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('recipient_code', 'Recipient Post Code:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('recipient_code', null, array('class'=>'form-control', 'placeholder'=>'ie. 00100')) !!}
    </div>
</div>

<br>
<br>
<div class="form-group">
    {!! Form::label('recipient_town', 'Recipient Town:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::select('recipient_town', (['0'  => 'Select Your Destination Town'] + $towns), null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('letter_weight', 'Letter Weight & Cost:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::select('letter_weight', (['0'  => 'Select Your Letter Weight'] + $postage_rates), null, ['class' => 'form-control', 'required']) !!}
    
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

