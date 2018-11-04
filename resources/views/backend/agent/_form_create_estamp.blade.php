@include('includes.errors')


<div class="form-group">
    {!! Form::label('sender_phone', 'Sender Phone No:', array('class'=>'col-sm-3 control-label')) !!}                        
    <div class="col-sm-6">
        {!! Form::text('sender_phone', null, array('class'=>'form-control', 'placeholder'=>'ie. 0710xxxxxx')) !!}
    </div>
</div>
<br>
<br>
<br>
<div class="form-group">
    {!! Form::label('sender_name', 'Sender Names:', array('class'=>'col-sm-3 control-label')) !!}                        
    <div class="col-sm-6">
        {!! Form::text('sender_name', null, array('class'=>'form-control', 'placeholder'=>'ie. Eva Maina')) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('destination_box', 'Destination Box No:', array('class'=>'col-sm-3 control-label')) !!}                        
    <div class="col-sm-6">
        {!! Form::text('destination_box', null, array('class'=>'form-control', 'placeholder'=>'ie. 5623348')) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('destination_code', 'Destination Post Code:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('destination_code', null, array('class'=>'form-control', 'placeholder'=>'ie. 00100')) !!}
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
    {!! Form::label('recipient_name', 'Recipient Name:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('recipient_name', null, array('class'=>'form-control', 'placeholder'=>'ie. John Otieno')) !!}                                        
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
    {!! Form::label('destination_town', 'Destination Town:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::select('destination_town', (['0'  => 'Select Your Destination Town'] + $towns), null, ['class' => 'form-control', 'required']) !!}
    
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
<!-- <div class="form-group">
    {!! Form::label('price', 'Your Parcel Price:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('price', null, array('class'=>'form-control', 'disabled')) !!}   
    </div>
</div>
<br>
<br> -->
                   
                

<div class="form-group row">
    <div class="col-sm-6 col-md-5">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success full-width btn-large']) !!}
        or &nbsp; <a href="{{ route('estamps.index') }}" class="soap-popupbox">Cancel</a>
    </div>
</div>

