@include('includes.errors')

<div class="form-group">
    {!! Form::label('stamp_code', 'Stamp Code:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('stamp_code', $code, array('class'=>'form-control', 'readonly')) !!}
        <input type="hidden" name="delivery_select" value="1" id="delivery_select" >
    </div>
</div>
<br>
<br>
<br>

<div class="form-group">
    {!! Form::label('Delivery Option', 'Type Of Delivery:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        <select name="delivery_type" id="delivery_type">
            <option name="normal" id="normal" value="1">Normal Delivery</option>
            <option name="ems" id="ems" value="2">EMS Delivery</option>
        </select>
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

