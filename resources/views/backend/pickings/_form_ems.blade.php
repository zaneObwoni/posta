{{--beginning of section scripts--}}
<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<link href="/css/adjust.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
{{--end of script section--}}

@include('includes.errors')

<div class="form-group">
    {!! Form::label('stamp_code', 'Stamp Code:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('stamp_code', $code, array('class'=>'form-control', 'readonly')) !!}
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
            {!! Form::text('category', 'EMS ', array('class'=>'form-control', 'readonly')) !!}
        @endif
        
    </div>
</div>
<br>
<br>

<div class="form-group">
    {!! Form::label('sub_category', 'Select EMS Letter :', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        <select name="sub_category" id="sub_category">
            <option>Select EMS Letter</option>
            <option name="1" value="1">Bahasha Kasha (Domestic Document Express)</option>
            <option name="2" value="2">EMS (Overnight)</option>
            <option name="3" value="3">EMS BAG RATE - Overnight</option>
            <option name="4" value="4">EMS BULK RATE</option>
            <option name="5" value="5">EMS (Nairobi to selected Destination By Road)</option>
            <option name="6" value="6">EMS (Nairobi to selected Destination by Air)</option>

        </select>
    </div>
</div>
<br>
<br>

<div class="form-group">
    {!! Form::label('amount', 'Other Options:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {{--{!! Form::select('amount', (['0'  => 'Select Approx. KMs from nearest Post Office'] + $delivery_rates), null, ['class' => 'form-control', 'required']) !!}--}}
        <select name="distance" id="distance" class="form-control">
            <option>
                Select Option
            </option>
        </select>
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('weight', 'Extra weight (Kg)(If any):', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::number('weight', null, array('class'=>'form-control', 'placeholder'=>'ie. 8','id'=>'weight','name'=>'weight','autocomplete'=>"off")) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('amount', 'Total Amount (Ksh):', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('amount', null, array('class'=>'form-control','readonly', 'required')) !!}

    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('building_name', 'Picking Building/Floor:', array('class'=>'col-sm-3 control-label')) !!}
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

<div class="form-group row">
    <div class="col-sm-6 col-md-5">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-success full-width btn-large']) !!}
        or &nbsp; <a href="{{ route('deliveries.index') }}" class="soap-popupbox">Cancel</a>
    </div>
</div>

<script>
    $('#sub_category').change(function () {
//alert('Am already inside');

        var sub_category = document.getElementById("sub_category").value;
        //alert(ems_let);

        $.get('register_postcode/' + sub_category + '/postboxes.json', function (postboxes) {
            var $distance = $('#distance');

            $distance.find('option').remove().end();
            if (sub_category == 1 ||sub_category == 2 ||sub_category == 3 || sub_category == 4) {

                $.each(postboxes, function (index, postbox) {
                    $distance.append('<option value="' + postbox.price + '">' + postbox.distance + ' - ' + postbox.weight + ' - Ksh.' + postbox.price + '</option>');

                });
            }
            if (sub_category == 5 ||sub_category == 6) {

                $.each(postboxes, function (index, postbox) {
                    $distance.append('<option value="' + postbox.price + '">' + postbox.route + ' - ' + postbox.weight + ' - Ksh.' + postbox.price + '</option>');

                });
            }

        });
    });

    $('#distance').change(function () {
        document.getElementById("amount").value = document.getElementById("distance").value;
    });

    $('#weight').change(function () {
        var total=document.getElementById("amount").value;
        var weight=document.getElementById("weight").value;
        var new_total =+total+(weight*50);


        document.getElementById("amount").value = new_total;
    });


</script>
