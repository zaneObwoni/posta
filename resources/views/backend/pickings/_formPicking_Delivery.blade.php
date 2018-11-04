@include('includes.errors')
<style>
    h4{
        text-align: center;
        font-size: 18px;
        font-weight: bold;
    }
</style>
<h4>Item Details</h4>
<br>
<div class="form-group">
    {!! Form::label('means', 'Item Option :', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        <select id="means" name="means" required onchange="Updatecost()">
            <option value="">Select Item best option</option>
            <option value="200">0 - 5 km & 0 - 2Kgs on Foot KES. 200</option>
            <option value="300">0 - 5 km & 2- 5Kgs on Foot KES. 300</option>

            <option value="300">0 - 5 km & 0 - 5Kgs by Motobike KES. 300</option>
            <option value="500">0 - 5 km & 5 - 10 by Motobike  KES. 500</option>
            <option value="1000">0 - 5 km & 10 - 100 by Motobike  KES. 1000</option>


            <option value="800">5 - 10 km & 0 - 5Kgs by Motobike KES. 800</option>
            <option value="1500">5 - 10 km & 5 - 10 by Motobike  KES. 1500</option>
            <option value="2500">5 - 10 km & 10 - 100 by Motobike  KES. 2500</option>

            <option value="800">10 - 15 km & 0 - 5Kgs by Motobike KES. 800</option>
            <option value="2500">10 - 15 km & 5 - 10 by Motobike  KES. 2500</option>
            <option value="3500">10 - 15  km & 10 - 100 by Motobike  KES. 3500</option>

            <option value="1000">15 - 20 km & 0 - 5Kgs by Motobike KES. 1000</option>
            <option value="3500">15 - 20 km & 5 - 10 by Motobike  KES. 3500</option>
            <option value="4500">15 - 20  km & 10 - 100 by Motobike  KES. 4500</option>

            <option value="4000">0 - 5 km & 100 - 3000Kgs by 3ton Truck KES. 4000</option>
            <option value="6000">5 - 10 km & 5 - 10 by 3ton Truck  KES. 6000</option>
            <option value="8000">10 - 15 km & 10 - 100 by 3ton Truck  KES. 8000</option>
            <option value="10000">15 - 20 km & 10 - 100 by 3ton Truck  KES. 10000</option>

            <option value="5000">0 - 5 km & 100 - 3000Kgs by 5ton Truck KES. 5000</option>
            <option value="7000">5 - 10 km & 5 - 10 by 5ton Truck  KES. 7000</option>
            <option value="9000">10 - 15 km & 10 - 100 by 5ton Truck  KES. 9000</option>
            <option value="11000">15 - 20 km & 10 - 100 by 5ton Truck  KES. 11000</option>

            <option value="6000">0 - 5 km & 100 - 3000Kgs by 7ton Truck KES. 6000</option>
            <option value="8000">5 - 10 km & 5 - 10 by 7ton Truck  KES. 8000</option>
            <option value="10000">10 - 15 km & 10 - 100 by 7ton Truck  KES. 10000</option>
            <option value="12000">15 - 20 km & 10 - 100 by 7ton Truck  KES. 12000</option>

        </select>
    </div>
</div>
<br>

<div class="form-group">
    {!! Form::label('description', 'Item Description:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('description', null, array('class'=>'form-control', 'placeholder'=>'ie. about your item', 'required')) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('estimated_cost', 'Estimated Values (KES)', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::number('estimated_cost', null, array('class'=>'form-control', 'placeholder'=>'ie. 1000', 'required')) !!}
    </div>
</div>
<br>
<br>
<br>
<h4>Picking Details</h4>
<div class="form-group">
    {!! Form::label('building_name', 'Picking Building:', array('class'=>'col-sm-3 control-label')) !!}                        
    <div class="col-sm-6">
        {!! Form::text('building_name', null, array('class'=>'form-control', 'placeholder'=>'ie. Thika Naivas Supermarket', 'required')) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('street', 'Picking Street:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('street', null, array('class'=>'form-control', 'placeholder'=>'ie. Kenyatta Street', 'required')) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('town', 'Delivery Town:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('town', null, array('class'=>'form-control', 'placeholder'=>'ie. Thika', 'required')) !!}
    </div>
</div>
<br>

<h4>Delivery Details</h4>
<div class="form-group">
    {!! Form::label('d_building_name', 'Delivery Building:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('d_building_name', null, array('class'=>'form-control', 'placeholder'=>'ie. Nairobi Posta GPO ', 'required')) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('d_street', 'Delivery Street:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('d_street', null, array('class'=>'form-control', 'placeholder'=>'ie. Kenyatta Avenue Street', 'required')) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('d_town', 'Delivery Town:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::text('d_town', null, array('class'=>'form-control', 'placeholder'=>'ie. Nairobi', 'required')) !!}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {!! Form::label('cost', 'Total cost:', array('class'=>'col-sm-3 control-label')) !!}
    <div class="col-sm-6">
        {!! Form::number('cost', null, array('class'=>'form-control','readonly')) !!}
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

<script type="text/javascript">
    function Updatecost() {
        var cost=document.getElementById('means').value;
        //var Tcost=parseInt(cost);
        document.getElementById('cost').value=cost;
        //alert(cost);
    }
</script>