<div class="form-group col-sm-12 col-md-12 ">
    <h3 class = "text-center">Company Information</h3>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for ="logo">Upload logo</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    @isset($company->logo)
        <img class="logo-edit" src="{{ $company->logo }}">
    @endisset
    <input type="file" name="logo" id="logo" class="" placeholder="">
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="primary_contact_name">Primary contact Name</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="primary_contact_name" id="primary_contact_name" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->primary_contact_name : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="primary_contact_phone_number">Primary Contact Phone Number
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="primary_contact_phone_number" id="primary_contact_phone_number" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->primary_contact_phone_number : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="primary_contact_email_address">Primary Contact Email Address</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="primary_contact_email_address" id="primary_contact_email_address" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->primary_contact_email_address : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="address_line_1">Address Line 1</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="address_line_1" id="address_line_1" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->address_line_1 : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="address_line_2">Address Line 2</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="address_line_2" id="address_line_2" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->address_line_2 : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="city">City</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="city" id="city" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->city : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="state">State</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    {{ Form::select('state', ['' => '']+$states->toArray(), null, ['id' => 'state', 'class' => 'form-control effect-1']) }}
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="zip">Zip</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="zip" id="zip" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->zip : null}}">
    <span class="focus-border"></span>
</div>