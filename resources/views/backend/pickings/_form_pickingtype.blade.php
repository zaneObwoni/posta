@include('includes.errors')

<div class="form-group">
    {!! Form::label('stamp_code', 'Stamp Code:', array('class'=>'col-sm-3 control-label')) !!}                        
    <div class="col-sm-6">
        {!! Form::text('stamp_code', $code, array('class'=>'form-control', 'readonly')) !!}
        <input type="hidden" name="picking_select" value="1" id="picking_select" >
    </div>
</div>
<br>
<br>
<br>

<div class="form-group">
    {!! Form::label('Types of PIcking', 'Type of Picking:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        <select name="picking_type" id="picking_type">
            <option name="normal" id="normal" value="1">Normal Picking</option>
            <option name="ems" id="ems" value="2">EMS Picking</option>
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

