@include('includes.errors')


<div class="form-group">
    {!! Form::label('stamp_code', 'Stamp Code:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('stamp_code', null, array('class'=>'form-control', 'placeholder'=>'Enter stamp code ie. Ab23xxxxxx')) !!}
    </div>
</div>
<br>
<br>
<br>
                   
                

<div class="form-group row">
    <div class="col-sm-6 col-md-5">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success full-width btn-large']) !!}
        or &nbsp; <a href="{{ route('estamps.index') }}" class="soap-popupbox">Cancel</a>
    </div>
</div>

