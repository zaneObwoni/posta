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
        {!! Form::select('season', ([''  => 'Select Your Season Card'] + $seasons), null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('recipient_town', 'Recipient Town:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::select('recipient_town', ([''  => 'Select Your Destination Town'] + $towns), null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('letter_weight', 'Letter Weight & Cost:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::select('letter_weight', ([''  => 'Select Your Letter Weight'] + $postage_rates), null, ['class' => 'form-control', 'required']) !!}
    
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
{!! Form::label('Upload', 'Upload Excel: ', array('class'=>'col-sm-3 control-label')) !!}

{!! Form::file('file', null, array('class'=>'input-text full-width','required')) !!}

<br>
(<a href="/sheet2.xlsx"> View sample excel</a>
<br>
<br>

<div class="form-group row">
    <div class="col-sm-6 col-md-5">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success full-width btn-large']) !!}
        or &nbsp; <a href="{{ route('estamps.index') }}" class="soap-popupbox">Cancel</a>
    </div>
</div>

