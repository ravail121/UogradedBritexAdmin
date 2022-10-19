<div class="form-group col-sm-12 col-md-12 ">
    <h3 class = "text-center">Reseller Account Status</h3>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for ="reseller_status">Reseller Account Status</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="reseller_status" id="reseller_status" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->reseller_status : null}}">
    <span class="focus-border"></span>
</div>