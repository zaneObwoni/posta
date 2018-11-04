@include('includes.errors')

<div class="form-group">
    {!! Form::label('name', 'Name:', array('class'=>'col-sm-3 control-label')) !!}                        
    <div class="col-sm-6">
        {!! Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'ie. John De')) !!}
    </div>
</div>
<br>
<br>
<br>
<div class="form-group">
    {!! Form::label('id_number', 'ID Number:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('id_number', null, array('class'=>'form-control', 'placeholder'=>'ie. 9823897283')) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('phone', 'Phone:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('phone', null, array('class'=>'form-control', 'placeholder'=>'ie. 0711345453')) !!}
    </div>
</div>
<br>
<br>

<div class="form-group">
    {!! Form::label('stamp_code', 'Stamp Code:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('stamp_code', null, array('class'=>'form-control', 'placeholder'=>'ie. Your Stamp Code')) !!}
    </div>
</div>
<br>
<br>

<br>

<div class="form-group row">
    <div class="col-sm-6 col-md-5">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success full-width btn-large']) !!}
        or &nbsp; <a href="{{ route('deliveries.index') }}" class="soap-popupbox">Cancel</a>
    </div>
</div>

