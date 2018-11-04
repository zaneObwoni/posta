@include('includes.errors')


<div class="form-group">
    {!! Form::label('first_name', 'Contact Name:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('first_name', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Name e.g posta',
            'required',
            'id'                            => 'inputfirstName',
            'data-parsley-required-message' => 'First Name is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'first_name'

        ]) !!}
    </div>
</div>
<br>

<div class="form-group">
    {!! Form::label('phone', 'Phone:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('phone', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Contact Phone',
            'required',
            'id'                            => 'inputphone',
            'data-parsley-required-message' => 'phone is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'phone'

        ]) !!}
    </div>
</div>
<br>

<div class="form-group">
    {!! Form::label('town', 'City/Town:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('town', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Enter your Town',
            'required',
            'id'                            => 'inputtown',
            'data-parsley-required-message' => 'town is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'town'

        ]) !!}
    </div>
</div>
<br><br>
<div class="form-group">
    {!! Form::label('postcode_id', 'Post Code:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::select('postcode_id', (['0'  => 'Select Post Code'] + $post_codes), null, [
            'class'                         => 'form-control',
            'required',
            'id'                            => 'postcode_id',
            'data-parsley-required-message' => 'postcode_id is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-minlength'        => '2',
            'data-parsley-maxlength'        => '20'

        ]) !!}
    </div>
</div>
<br>
<div class="form-group">
    {!! Form::label('postbox_id', 'Post box:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('postbox_id', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'e.g 2501',
            'required',
            'id'                            => 'postbox_id',
            'data-parsley-required-message' => 'posta_email is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'posta_email'

        ]) !!}
    </div>
</div>
                   
          <br> <br>

<div class="form-group row">
    <div class="col-sm-6 col-md-5">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success full-width btn-large']) !!}
        or &nbsp; <a href="{{ route('estamps.contact') }}" class="soap-popupbox">Cancel</a>
    </div>
</div>

