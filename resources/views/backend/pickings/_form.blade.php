@include('includes.errors')

<div class="form-group">
    {!! Form::label('stamp_code', 'Stamp Code:', array('class'=>'col-sm-3 control-label')) !!}                        
    <div class="col-sm-6">
        {!! Form::text('stamp_code', $code, array('class'=>'form-control', 'readonly', 'required')) !!}
    </div>
</div>
<br>
<br>
<br>
<div class="form-group">
    {!! Form::label('category', 'Category:', array('class'=>'col-sm-3 control-label')) !!}                        
    <div class="col-sm-6">
        @if($pick == 1)
            {!! Form::text('category', 'NORMAL', array('class'=>'form-control', 'readonly')) !!}
        @else
            {!! Form::text('category', 'EMS ', array('class'=>'form-control', 'readonly', 'required')) !!}
        @endif
        
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('building_name', 'Picking Building:', array('class'=>'col-sm-3 control-label')) !!}                        
    <div class="col-sm-6">
        {!! Form::text('building_name', null, array('class'=>'form-control', 'placeholder'=>'ie. Bishop Magua Building', 'required')) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('street', 'Picking Street:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('street', null, array('class'=>'form-control', 'placeholder'=>'ie. Mama Ngina Street', 'required')) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('town', 'Picking Town:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('town', null, array('class'=>'form-control', 'placeholder'=>'ie. Nakuru', 'required')) !!}
    </div>
</div>
<br>
<br>

<div class="form-group">
    {!! Form::label('amount', 'KMs from Post-Office:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::select('amount', [null => 'Select Approx. KMs from nearest Post Office'] + $delivery_rates, null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>
<br>
<br>

<!-- <div class="form-group">
    {!! Form::label('weight', 'Estimate Parcel Weight:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! DB::table('estamps')->where('code', $code)->value('letter_weight'); !!} KG
    </div>
</div>
<br>
<br> -->

<br>

<div class="form-group row">
    <div class="col-sm-6 col-md-5">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success full-width btn-large']) !!}
        or &nbsp; <a href="{{ route('deliveries.index') }}" class="soap-popupbox">Cancel</a>
    </div>
</div>

