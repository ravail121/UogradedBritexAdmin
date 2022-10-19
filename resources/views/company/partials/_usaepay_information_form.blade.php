<div class="form-group col-sm-12 col-md-12 ">
    <h3 class = "text-center">USAePay information</h3>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
        <div class="col-sm-6 col-md-1">
            {!! Form::checkbox('1', '1', isset($company) ? $company->usaepay_live : null , ['name' => 'usaepay_live', 'id' => 'usaepay_live', 'class'=>'edit-device-checkbox']) !!}
        </div>
        <div class="col-sm-6 col-md-11 checkbox-label">
            <label class="" for ="usaepay_live">USAePay Live</label>
        </div>
    </div>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="usaepay_api_key">USAePay API Key</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="usaepay_api_key" id="usaepay_api_key" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->usaepay_api_key : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="usaepay_username">USAePay Username</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="usaepay_username" id="usaepay_username" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->usaepay_username : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="usaepay_password">USAePay Password
</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="usaepay_password" id="usaepay_password" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->usaepay_password : null}}">
    <span class="focus-border"></span>
</div>
