@include('includes.errors')

{{--{!! dd($staff) !!}--}}
<div class="form-group">
    {!! Form::label('first_name', 'First Name:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('first_name', $staff->first_name, [

            'class'                         => 'form-control',
            'placeholder'                   => 'Enter Staff first Name',
            'required',
            'id'                            => 'first_name',
            'data-parsley-required-message' => 'first_name is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'first_name'

        ]) !!}
    </div>
</div>
<br><br><br>
<div class="form-group">
    {!! Form::label('last_name', 'Last Name:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('last_name', $staff->last_name, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Enter Staff Last Name',
            'required',
            'id'                            => 'last_name',
            'data-parsley-required-message' => 'last_name is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'last_name'

        ]) !!}
    </div>
</div>
<br><br>
<div class="form-group">
    {!! Form::label('employee_no', 'Employee No:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('employee_no', $staff->employee_no, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Enter Staffs employee No',
            'required',
            'id'                            => 'employee_no',
            'data-parsley-required-message' => 'employee_no is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'employee_no'

        ]) !!}
    </div>
</div>
<br><br>
<div class="form-group">
    {!! Form::label('identification_number', 'National ID:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('identification_number', $staff->identification_number, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Enter Employees National ID',
            'required',
            'id'                            => 'inputidentification_number',
            'data-parsley-required-message' => 'identification_number is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'identification_number'

        ]) !!}
    </div>
</div>
<br><br>
<div class="form-group">
    {!! Form::label('pin', 'PIN:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('pin', $staff->pin, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Enter KRA PIN....',
            'required',
            'id'                            => 'pin',
            'data-parsley-required-message' => 'identification_number is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'pin'

        ]) !!}
    </div>
</div>
<br><br>
<div class="form-group">
    {!! Form::label('county_id', 'County:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::select('county_id', (['0'  => 'Select your County'] + $counties), null, [
            'class'                         => 'form-control',
            'required',
            'id'                            => 'inputPassword',
            'data-parsley-required-message' => 'Password is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-minlength'        => '2',
            'data-parsley-maxlength'        => '20'
        ]) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('city', 'City:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('city', $staff->town, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Enter Employee City',
            'required',
            'id'                            => 'city',
            'data-parsley-required-message' => 'city is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'city'

        ]) !!}
    </div>
</div>

<br><br>
<div class="form-group">
    {!! Form::label('current_email', 'Alternative Email:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('current_email', $staff->current_email, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Enter Employees email address',
            'required',
            'id'                            => 'current_email',
            'data-parsley-required-message' => 'current_email is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'current_email'

        ]) !!}
    </div>
</div>
<br><br>
<div class="form-group">
    {!! Form::label('phone', 'Phone Number:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('phone', $staff->phone, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Enter Employees phone No',
            'required',
            'id'                            => 'phone',
            'data-parsley-required-message' => 'phone is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'phone'

        ]) !!}
    </div>
</div>

<br>
<br>
<div class="form-group">
    {!! Form::label('gender', 'Gender:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        <select name="gender" id="gender" class="form-control">
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="Female">Female</option>
            <option value="other">Other</option>
        </select>
    </div>
</div>


<br>
<br>

<div class="form-group">
    {!! Form::label('postcode_id', 'Post Code:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::select('postcode_id', (['0'  => 'Select Staff Post Code'] + $post_codes), null, [
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
<br>
<div class="form-group">
    {!! Form::label('posta_email', 'Login Email:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('posta_email', $staff->email, [
            'class'                         => 'form-control',
            'placeholder'                   => 'e.g Staffemail@posta.co.ke',
            'required',
            'id'                            => 'posta_email',
            'data-parsley-required-message' => 'email is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'Posta_email'
        ]) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('password', 'Password:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::password('password', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'password',
            'required',
            'id'                            => 'password',
            'data-parsley-required-message' => 'password is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'password'
        ]) !!}
    </div>
</div>
<br>
<br>


<div class="form-group">
    {!! Form::label('role', 'User Role:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::select('role', (['0'  => 'Select User Rank'] + $role), null, [
            'class'                         => 'form-control',
            'required',
            'id'                            => 'role',
            'data-parsley-required-message' => 'role is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-minlength'        => '2',
            'data-parsley-maxlength'        => '20'
        ]) !!}
    </div>
</div>
<br>
<br>
<br>


<div class="form-group row">
    <div class="col-sm-6 col-md-5">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success full-width btn-large']) !!}
        or &nbsp; <a href="{{ route('admin.staffs') }}" class="soap-popupbox">Cancel</a>
    </div>
</div>

