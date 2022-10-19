<div class="form-group col-sm-12 col-md-12">
    <h3 class="text-center">Invoice Branding</h3>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="invoice_background_text_color">Background Text Color</label>
</div>
<div class="form-group col-sm-12 col-md-3 color-picker-container">
    <input type="text" name="invoice_background_text_color" id="background_text_color" class="form-control effect-1 invoice-branding-color-picker"  value= "{{ isset($company) ? $company->invoice_background_text_color : '#FFFFFF' }}">
    <span class="focus-border"></span>
    <div class="actionbtn mt-10">
        <a href="javascript:void(0);" data-default-value="#FFFFFF" class="btn reset-color-selection markbtn createbtn mt2">Reset</a>
    </div>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="invoice_normal_text_color">Normal Text Color</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="invoice_normal_text_color" id="normal_text_color" class="form-control effect-1 invoice-branding-color-picker" value= "{{ isset($company) ? $company->invoice_normal_text_color : '#373737' }}">
    <span class="focus-border"></span>
    <div class="actionbtn mt-10">
        <a href="javascript:void(0);" data-default-value="#373737" class="btn reset-color-selection markbtn createbtn mt2">Reset</a>
    </div>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="invoice_account_summary_primary_color">Account Summary Primary Color</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="invoice_account_summary_primary_color" id="account_summary_primary_color" class="form-control effect-1 invoice-branding-color-picker" value= "{{ isset($company) ? $company->invoice_account_summary_primary_color : '#4c00ac' }}">
    <span class="focus-border"></span>
    <div class="actionbtn mt-10">
        <a href="javascript:void(0);" data-default-value="#4c00ac" class="btn reset-color-selection markbtn createbtn mt2">Reset</a>
    </div>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="invoice_account_summary_secondary_color">Account Summary Secondary Color</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="invoice_account_summary_secondary_color" id="account_summary_secondary_color" class="form-control effect-1 invoice-branding-color-picker" value= "{{ isset($company) ? $company->invoice_account_summary_secondary_color : '#420590' }}">
    <span class="focus-border"></span>
    <div class="actionbtn mt-10">
        <a href="javascript:void(0);" data-default-value="#420590" class="btn reset-color-selection markbtn createbtn mt2">Reset</a>
    </div>
</div>
<div class="form-group col-sm-12 col-md-3">
    <label for="invoice_solid_line_color">Solid Lines Color</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="invoice_solid_line_color" id="invoice_solid_line_color" class="form-control effect-1 invoice-branding-color-picker" value= "{{ isset($company) ? $company->invoice_solid_line_color : '#000' }}">
    <span class="focus-border"></span>
    <div class="actionbtn mt-10">
        <a href="javascript:void(0);" data-default-value="#000" class="btn reset-color-selection markbtn createbtn mt2">Reset</a>
    </div>
</div>