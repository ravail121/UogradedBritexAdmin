<div class="form-group col-sm-12 col-md-12">
    <h3 class = "text-center">ReadyCloud information</h3>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="readycloud_api_key">ReadyCloud API key</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="readycloud_api_key" id="readycloud_api_key" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->readycloud_api_key : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="readycloud_username">ReadyCloud Username</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="readycloud_username" id="readycloud_username" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->readycloud_username : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="readycloud_password">ReadyCloud Password
</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="readycloud_password" id="readycloud_password" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->readycloud_password : null}}">
    <span class="focus-border"></span>
</div>
