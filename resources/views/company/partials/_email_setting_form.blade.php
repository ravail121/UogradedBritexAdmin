<div class="form-group col-sm-12 col-md-12 ">
    <h3 class = "text-center">Email Settings</h3>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="smtp_driver">SMTP Driver</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="smtp_driver" id="smtp_driver" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->smtp_driver : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="smtp_host">SMTP Host</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="smtp_host" id="smtp_host" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->smtp_host : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="smtp_port">SMTP Port</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="smtp_port" id="smtp_port" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->smtp_port : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="smtp_username">SMTP User</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="smtp_username" id="smtp_username" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->smtp_username : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="smtp_password">SMTP Password</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="smtp_password" id="smtp_password" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->smtp_password : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="email_header">Email Header</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="email_header" id="email_header" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->email_header : null}}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="email_footer">Email Footer</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="email_footer" id="email_footer" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->email_footer : null}}">
    <span class="focus-border"></span>
</div>