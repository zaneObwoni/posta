<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<style>
    html, body {
        height: 100%;
    }

    body {
        /*     margin: 0;
             padding: 0;
             width: 100%;
             display: table;
             font-weight: 100;
             color: #000;*/
        font-family: 'Arial';
    }

    .container {
        text-align: center;
        /*display: table-cell;*/
        vertical-align: middle;
    }

    .content {
        text-align: center;
        display: inline-block;
    }

    .title {
        font-size: 96px;
    }
    .ui-datepicker-year{
        background-color: black;
    }
</style>

<script type="text/javascript">
    $(function () {
        var start = new Date();
        start.setFullYear(start.getFullYear() - 1);
        var end = new Date();
        end.setFullYear(end.getFullYear() +50);

        $('#expiry_date').datepicker({
            dateFormat : 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            minDate: start,
            maxDate: end,
            yearRange: start.getFullYear() + ':' + end.getFullYear()
        });
        $('#licence_expiry').datepicker({
            dateFormat : 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            minDate: start,
            maxDate: end,
            yearRange: start.getFullYear() + ':' + end.getFullYear()
        });
    });
</script>
@include('includes.errors')

<div class="form-group">
    {!! Form::label('first_name', 'First Name:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('first_name', null, [
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
        {!! Form::text('last_name', null, [
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
        {!! Form::text('employee_no', null, [
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
        {!! Form::text('identification_number', null, [
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
    {!! Form::label('city', 'City:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('city', null, [
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
    {!! Form::label('postcode', 'Postcode:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('postcode', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Enter Employee postcode',
            'required',
            'id'                            => 'postcode',
            'data-parsley-required-message' => 'postcode is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'postcode'

        ]) !!}
    </div>
</div>

<br><br>
<div class="form-group">
    {!! Form::label('email', 'Email:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('email', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'Enter Employees email address',
            'required',
            'id'                            => 'email',
            'data-parsley-required-message' => 'email is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'email'

        ]) !!}
    </div>
</div>
<br><br>
<div class="form-group">
    {!! Form::label('phone', 'Phone Number:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('phone', null, [
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
    {!! Form::label('driving_licence', 'Driving Licence No:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('driving_licence', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'ie. 331AS',
            'required',
            'id'                            => 'driving_licence',
            'data-parsley-required-message' => 'insurance_no is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'insurance_no'
        ]) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('licence_expiry', 'Licence Expiry Date:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('licence_expiry', null, [
            'class'                         => 'form-control',
            'placeholder'                   => '',
            'required',
            'id'                            => 'licence_expiry',
            'data-parsley-required-message' => 'expiry_date is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'expiry_date'
        ]) !!}
    </div>
</div>

<br>
<br>
<div class="form-group">
    {!! Form::label('vehicle_type', 'Vehicle Type:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        <select name="vehicle_type" id="vehicle_type" class="form-control">
            <option value="Lorry"> Lorry</option>
            <option value="Pick-Up"> Pick Up</option>
            <option value="Motorcycle"> Motorcycle</option>
        </select>
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('reg_no', 'Vehicle Registration No:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('reg_no', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'ie. KYG 762',
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
    {!! Form::label('insurance_no', 'Insurance No:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('insurance_no', null, [
            'class'                         => 'form-control',
            'placeholder'                   => 'ie. 331AS',
            'required',
            'id'                            => 'insurance_no',
            'data-parsley-required-message' => 'insurance_no is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'insurance_no'
        ]) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('expiry_date', 'Expiry Date:*', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
    <div class="col-lg-10">
        {!! Form::text('expiry_date', null, [
            'class'                         => 'form-control',
            'placeholder'                   => '',
            'required',
            'id'                            => 'expiry_date',
            'data-parsley-required-message' => 'expiry_date is required',
            'data-parsley-trigger'          => 'change focusout',
            'data-parsley-type'             => 'expiry_date'
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

