<div class="form-group col-sm-12 col-md-4">
    <label for ="{{ $form }}name">Name<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="name" id="{{ $form }}name" class="form-control effect-1" placeholder="Name">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for ="{{ $form }}sku">SKU</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="sku" id="{{ $form }}sku" class="form-control effect-1" placeholder="SKU">
    <span class="focus-border"></span>
</div>


<div class="form-group col-sm-12 col-md-4">
    <label for ="{{ $form }}tag_id">Tag</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('tag_id', ['' => ''] + $tag->toArray(), null, ['id' => $form.'tag_id', 'class' => 'form-control effect-1']) }}
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for ="{{ $form }}type">Type<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('type', ['' => ''] + $type, null, ['id' => $form.'type', 'class' => 'form-control effect-1']) }}
</div>


<div class="form-group col-sm-12 col-md-4">
    <label for ="{{ $form }}type">Carrier<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('carrier_id', $carrier, null, ['id' => $form.'carrier_id', 'class' => 'form-control effect-1']) }}
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for ="area_code">Area Code<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('area_code', ['' => ''] + $areaCode, null, ['id' => 'area_code', 'class' => 'form-control effect-1']) }}
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
        <div class="col-sm-6 col-md-2">
            <input type="checkbox" class="edit-product-checkbox" name="signup_porting" id="{{ $form }}signup_porting" value="1" checked>
        </div>
        <div class="col-sm-6 col-md-10 checkbox-label">
            <label class="" for ="{{ $form }}signup_porting">Sign Up Porting</label>
        </div>
    </div>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
        <div class="col-sm-6 col-md-2">
            <input type="checkbox" class="edit-product-checkbox" name="subsequent_porting" id="{{ $form }}subsequent_porting" value="1" checked>
        </div>
        <div class="col-sm-6 col-md-10 checkbox-label">
            <label class="" for ="{{ $form }}subsequent_porting">Subsequent Porting</label>
        </div>
    </div>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
        <div class="col-sm-6 col-md-2">
            <input type="checkbox" class="edit-product-checkbox" name="imei_required" id="{{ $form }}imei_required" value="1">
        </div>
        <div class="col-sm-6 col-md-10 checkbox-label">
            <label class="" for ="{{ $form }}imei_required">IMEI Required</label>
        </div>
    </div>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
        <div class="col-sm-6 col-md-2">
            <input type="checkbox" class="edit-product-checkbox" name="require_device_info" id="{{ $form }}require_device_info" value="1">
        </div>
        <div class="col-sm-6 col-md-10 checkbox-label">
            <label class="" for ="{{ $form }}require_device_info">Require Device Info</label>
        </div>
    </div>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
        <div class="col-sm-6 col-md-2">
            <input type="checkbox" class="edit-product-checkbox" name="sim_required" id="{{ $form }}sim_required" value="1">
        </div>
        <div class="col-sm-6 col-md-10 checkbox-label">
            <label class="" for ="{{ $form }}sim_required">SIM Required</label>
        </div>
    </div>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
        <div class="col-sm-6 col-md-2">
            <input type="checkbox" class="edit-product-checkbox" name="affilate_credit" id="{{ $form }}affilate_credit" value="1">
        </div>
        <div class="col-sm-6 col-md-10 checkbox-label">
            <label class="" for ="{{ $form }}affilate_credit">Gives Affiliate Credit</label>
        </div>
    </div>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
        <div class="col-sm-6 col-md-2">
            <input type="checkbox" class="edit-product-checkbox" name="subsequent_zip" id="{{ $form }}subsequent_zip" value="1">
        </div>
        <div class="col-sm-6 col-md-10 checkbox-label">
            <label class="" for ="{{ $form }}subsequent_zip">Subsequent ZIP</label>
        </div>
    </div>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
        <div class="col-sm-6 col-md-2">
            <input type="checkbox" class="edit-product-checkbox" name="own_sim_card_option" id="{{ $form }}own_sim_card_option" value="1">
        </div>
        <div class="col-sm-6 col-md-10 checkbox-label">
            <label class="" for="{{ $form }}own_sim_card_option">Enable Own Sim Card Option</label>
        </div>
    </div>
</div>

<div class="form-group col-sm-12 col-md-12">
    <label for= "description">Description:-</label>
</div>
<div class="form-group col-sm-12 col-md-12">
    <textarea name="description" id="description">
    </textarea>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for ="{{ $form }}notes">Notes</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="notes" id="{{ $form }}notes" class="form-control effect-1" placeholder="Notes">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}rate_plan_soc">Rate Plan SOC</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="rate_plan_soc" id="{{ $form }}rate_plan_soc" class="form-control effect-1" placeholder="Rate Plan SOC">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}rate_plan_bot_code">Rate Plan Bot Code</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="rate_plan_bot_code" id="rate_plan_bot_code" class="form-control effect-1" data-role="tagsinput">
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}data_soc">Data SOC Code</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="data_soc" id="{{ $form }}data_soc" class="form-control effect-1" placeholder="Data SOC Code">
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}plan_data_soc_bot_code">Data plan Bot Code</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="plan_data_soc_bot_code" id="{{ $form }}plan_data_soc_bot_code" class="form-control effect-1" data-role="tagsinput">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-6">
    <div class="row">
        <div class="form-group col-sm-6 col-md-6">
            <label for="image">Image</label>
        </div>
        <div class="form-group col-sm-6 col-md-6 data-product-image">
            {{-- <img class="product-image" data-toggle="modal" data-target="#product-image" src=""> --}}
        </div>
    </div>
</div>

<div class="form-group col-sm-12 col-md-6">
    <input type="file" name="image" id="image" class="form-control effect-1" placeholder="">
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}data_limit">Data Limit(In GB)</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="data_limit" id="{{ $form }}data_limit" class="form-control effect-1" placeholder="Data Limit">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}amount_recurring">Recurring Amount<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="amount_recurring" id="{{ $form }}amount_recurring" class="form-control effect-1" placeholder="Recurring Amount">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}amount_onetime">OneTime Amount<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="amount_onetime" id="{{ $form }}amount_onetime" value ="0" class="form-control effect-1" placeholder="One Time Amount">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="regulatory_fee_type">Regulatory Fee Type</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('regulatory_fee_type', $regulatoryFeeType, null, ['id' => 'regulatory_fee_type', 'class' => 'form-control effect-1']) }}
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}regulatory_fee_amount">Regulatory fee Amount<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="regulatory_fee_amount" id="{{ $form }}regulatory_fee_amount" class="form-control effect-1" placeholder="Regulatory fee Amount" value="0">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="show">Show<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('show', $show, 1, ['id' => 'show', 'class' => 'form-control effect-1']) }}
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}plan_block">Plan Block</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="plan_block" id="{{ $form }}plan_block" class="plan_block form-control effect-1" placeholder="">
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}custom_plan_name">Custom Plan Name</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="custom_plan_name" id="{{ $form }}custom_plan_name" class="form-control effect-1" value="" data-role="tagsinput">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}plan_to_addons">Plan to addons</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="plan_to_addons" id="{{ $form }}plan_to_addons" class="form-control effect-1 plan_to_addon" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}plan_to_addons">Associate with Coupon</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('auto_add_coupon_id', $coupons, null, ['id' => $form.'associate-with-coupon', 'class' => 'form-control effect-1']) }}
    <span class="focus-border">
    </span>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
        <div class="col-sm-6 col-md-2">
            <input type="checkbox" class="edit-product-checkbox" name="taxable" id="{{ $form }}taxable" value="1" checked>
        </div>
        <div class="col-sm-6 col-md-4 checkbox-label">
            <label class="" for ="{{ $form }}taxable">Taxable</label>
        </div>
    </div>
</div>