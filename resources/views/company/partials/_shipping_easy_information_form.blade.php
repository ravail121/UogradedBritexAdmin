<div class="form-group col-sm-12 col-md-12">
    <h3 class = "text-center">Shipping Easy Information</h3>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="shipping_easy_api_key">API Key</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="shipping_easy_api_key" id="shipping_easy_api_key" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->shipping_easy_api_key : null }}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="shipping_easy_api_secret">API Secret</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="shipping_easy_api_secret" id="shipping_easy_api_secret" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->shipping_easy_api_secret : null }}">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="shipping_easy_store_api_key">Store API Key</label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="shipping_easy_store_api_key" id="shipping_easy_store_api_key" class="form-control effect-1" placeholder="" value= "{{ isset($company) ? $company->shipping_easy_store_api_key : null }}">
    <span class="focus-border"></span>
</div>