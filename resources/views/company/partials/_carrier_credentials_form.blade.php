<div class="form-group col-sm-12 col-md-12">
    <h3 class = "text-center">Carrier Credentials</h3>
</div>

<div class="form-group col-sm-12 col-md-3 tmo display-none">
    <label for ="tbc_username">T-Mobile Business Center Username</label>
</div>
<div class="form-group col-sm-12 col-md-3 tmo display-none">
    <input type="text" name="tbc_username" id="tbc_username" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->tbc_username : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3 tmo display-none">
    <label for ="tbc_password">T-Mobile Business Center Password</label>
</div>
<div class="form-group col-sm-12 col-md-3 tmo display-none">
    <input type="text" name="tbc_password" id="tbc_password" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->tbc_password : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3 att display-none">
    <label for ="apex_username">Apex username
</label>
</div>
<div class="form-group col-sm-12 col-md-3 att display-none">
    <input type="text" name="apex_username" id="apex_username" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->apex_username : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3 att display-none">
    <label for ="apex_password">Apex password
</label>
</div>
<div class="form-group col-sm-12 col-md-3 att display-none">
    <input type="text" name="apex_password" id="apex_password" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->apex_password : null}}">
    <span class="focus-border"></span>
</div>


<div class="form-group col-sm-12 col-md-3 att display-none">
    <label for ="premier_username">Premier username
</label>
</div>
<div class="form-group col-sm-12 col-md-3 att display-none">
    <input type="text" name="premier_username" id="premier_username" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->premier_username : null}}">
    <span class="focus-border"></span>
</div>


<div class="form-group col-sm-12 col-md-3 att display-none">
    <label for ="premier_password">Premier Password
</label>
</div>
<div class="form-group col-sm-12 col-md-3 att display-none">
    <input type="text" name="premier_password" id="premier_password" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->premier_password : null }}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3 att display-none">
    <label for ="opus_usernames">OPUS Username
</label>
</div>
<div class="form-group col-sm-12 col-md-3 att display-none">
    <input type="text" name="opus_usernames" id="opus_usernames" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->opus_username : null }}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3 att display-none">
    <label for ="opus_password">OPUS Password
</label>
</div>
<div class="form-group col-sm-12 col-md-3 att display-none">
    <input type="text" name="opus_password" id="opus_password" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->opus_password : null }}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3 ultra display-none">
    <label for ="ultra_username">ULTRA Username
    </label>
</div>
<div class="form-group col-sm-12 col-md-3 ultra display-none">
    <input type="text" name="ultra_username" id="ultra_username" class="form-control effect-1" value= "{{ isset($company) ? $company->ultra_username : null }}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3 ultra display-none">
    <label for ="ultra_password">ULTRA Password
    </label>
</div>
<div class="form-group col-sm-12 col-md-3 ultra display-none">
    <input type="text" name="ultra_password" id="ultra_password" class="form-control effect-1" value= "{{ isset($company) ? $company->ultra_password : null }}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3 ultra display-none">
    <label for="ultra_api_key">ULTRA API Key
    </label>
</div>
<div class="form-group col-sm-12 col-md-3 ultra display-none">
    <input type="text" name="ultra_api_key" id="ultra_api_key" class="form-control effect-1" value= "{{ isset($company) ? $company->ultra_api_key : null }}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3 ultra display-none">
    <label for="ultra_api_secret">ULTRA API Secret
    </label>
</div>
<div class="form-group col-sm-12 col-md-3 ultra display-none">
    <input type="text" name="ultra_api_secret" id="ultra_api_secret" class="form-control effect-1" value= "{{ isset($company) ? $company->ultra_api_secret : null }}">
    <span class="focus-border"></span>
</div>