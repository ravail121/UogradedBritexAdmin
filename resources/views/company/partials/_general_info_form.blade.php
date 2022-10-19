<div class="form-group col-sm-12 col-md-12 ">
    <h3 class = "text-center">General Info</h3>
</div>
<div class="form-group col-sm-12 col-md-4">
    <label for ="name">Company Name<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="name" id="name" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->name : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for ="url">URL of Website<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="url" id="url" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->url : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
    <div class="col-sm-6 col-md-1">
        {!! Form::checkbox('1','1', isset($company) ? $company->selling_devices : null , ['name' => 'selling_devices', 'id' => 'selling_devices', 'class'=>'edit-device-checkbox']) !!}
    </div>
    <div class="col-sm-6 col-md-11 checkbox-label">
        <label class="" for ="selling_devices">Selling Devices</label>
    </div>
    </div>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
    <div class="col-sm-6 col-md-1">
        {!! Form::checkbox('1','1', isset($company) ? $company->selling_plans : null , ['name' => 'selling_plans', 'id' => 'selling_plans', 'class'=>'edit-device-checkbox']) !!}
    </div>
    <div class="col-sm-6 col-md-11 checkbox-label">
        <label class="" for ="selling_plans">Selling Plans</label>
    </div>
    </div>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
    <div class="col-sm-6 col-md-1">
        {!! Form::checkbox('1','1', isset($company) ? $company->selling_addons : null , ['name' => 'selling_addons', 'id' => 'selling_addons', 'class'=>'edit-device-checkbox']) !!}
    </div>
    <div class="col-sm-6 col-md-11 checkbox-label">
        <label class="" for ="selling_addons">Selling Addons</label>
    </div>
    </div>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
    <div class="col-sm-6 col-md-1">
        {!! Form::checkbox('1','1', isset($company) ? $company->selling_sim_standalone : null , ['name' => 'selling_sim_standalone', 'id' => 'selling_sim_standalone', 'class'=>'edit-device-checkbox']) !!}
    </div>
    <div class="col-sm-6 col-md-11 checkbox-label">
        <label class="" for ="selling_sim_standalone">Selling Sim Standalone</label>
    </div>
    </div>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
    <div class="col-sm-6 col-md-1">
        {!! Form::checkbox('1','1', isset($company) ? $company->business_verification : null , ['name' => 'business_verification', 'id' => 'business_verification', 'class'=>'edit-device-checkbox']) !!}
    </div>
    <div class="col-sm-6 col-md-11 checkbox-label">
        <label class="" for ="business_verification">Business Verification Required</label>
    </div>
    </div>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
        <div class="col-sm-6 col-md-1">
            {!! Form::checkbox('1', '1', isset($company) ? $company->enable_bulk_order : null , ['name' => 'enable_bulk_order', 'id' => 'enable_bulk_order', 'class'=>'edit-device-checkbox']) !!}
        </div>
        <div class="col-sm-6 col-md-11 checkbox-label">
            <label for ="enable_bulk_order">Enable Bulk Order</label>
        </div>
    </div>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="carrier_id">Carrier<span class="text-danger"> *</span></label>
    <br>
    <small style='opacity: 0.7'>Hold Ctrl button to select multiple</small>
</div>
<div class="form-group col-sm-12 col-md-3">
    <select name="carrier_id[]" class="form-control effect-1" id="carrier_id" multiple>
       {{-- <option></option> --}}
        @foreach($carriers as $key => $carrier)
            <option value="{{$carrier }}" data-slug = "{{$carrier->slug}}" {{ isset($company) && $company->carrier->first() && $company->carrier->pluck('id')->contains($carrier->id) ? 'selected': null }} >{{$carrier->name}} </option>
        @endforeach
    </select>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="regulatory_label">Regulatory Fees Label</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="regulatory_label" id="regulatory_label" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->regulatory_label : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="default_voice_reg_fee">Default Voice Regulatory Fee</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="default_voice_reg_fee" id="default_voice_reg_fee" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->default_voice_reg_fee : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="default_data_reg_fee">Default Data Regulatory Fee</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="default_data_reg_fee" id="default_data_reg_fee" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->default_data_reg_fee : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="support_phone_number">Support Phone Number</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="support_phone_number" id="support_phone_number" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->support_phone_number : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="support_email">Support Email Address<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="support_email" id="support_email" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->support_email : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="suspend_grace_period">Suspend Grace Period</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="suspend_grace_period" id="suspend_grace_period" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->suspend_grace_period : 30}}">
    <span class="focus-border"></span>
</div>

