<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $form }}active">Status</label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <label class="switch">
        <input type="checkbox" name="active" id="{{ $form }}active" class="form-control" checked="checked" value="1">    
        <span class="slider round"></span>
    </label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $form }}class">Class<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    {{ Form::select('class', ['' => ''] + $class, null, ['id' => $form.'class', 'class' => 'form-control effect-1 class']) }}
</div>
<div class="form-group col-sm-12 col-md-6 show-none productType1">
    <label for ="{{ $form }}type">Product Type<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6 show-none productType1">
    {{ Form::select('type', ['' => ''] + $productType, null, ['id' => $form.'type', 'class' => 'form-control effect-1 type']) }}
</div>
<div class="form-group col-sm-12 col-md-6 show-none sub_type">
    <label for ="{{ $form }}sub_type">Plan Type<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6 show-none sub_type">
    {{ Form::select('sub_type', ['' => ''] + $subType, null, ['id' => $form.'sub_type', 'class' => 'form-control effect-1 sub_type']) }}
</div>
<div class="form-group col-sm-12 col-md-6 show-none productType2">
    <label for ="{{ $form }}product_type">Product Type<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6 show-none productType2">
    {{ Form::select('product_type', ['' => ''] + $couponProductType, null, ['id' => $form.'product_type', 'class' => 'form-control effect-1 product_type']) }}
</div>
<div class="form-group col-sm-12 col-md-6 show-none product_id_label">
    <label for ="{{ $form }}product_id">Product Name<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6 show-none product_id product_name">
    <input type="hidden" name="product_id" id="{{ $form }}product_id" class="form-control effect-1 product_id_addon" placeholder="">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6 show-none device_id product_name">
    <input type="hidden" name="device_id" id="{{ $form }}device_id" class="form-control effect-1 device_to_addon" placeholder="">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6 show-none sim_id product_name">
    <input type="hidden" name="sim_id" id="{{ $form }}sim_id" class="form-control effect-1 sim_to_addon" placeholder="">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6 show-none addon_id product_name">
    <input type="hidden" name="addon_id" id="{{ $form }}addon_id" class="form-control effect-1 addon_to_addon" placeholder="">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $form }}fixed_or_perc">Fixed/Percentage<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    {{ Form::select('fixed_or_perc', ['' => ''] + $fixedPercentage, null, ['id' => $form.'fixed_or_perc', 'class' => 'form-control effect-1']) }}
</div>
<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $form }}amount">Amount<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="text" name="amount" id="{{ $form }}amount" class="form-control effect-1" placeholder="Amount">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $form }}name">Name<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="text" name="name" id="{{ $form }}name" class="form-control effect-1" placeholder="Name">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $form }}code">Code<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="text" name="code" id="{{ $form }}code" class="form-control effect-1" placeholder="Code">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $form }}num_cycles">Number of cycles to run<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="number" name="num_cycles" id="{{ $form }}num_cycles" class="form-control effect-1 num_cycles" placeholder="Number of cycles to run" min="0">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6">
    <label class='trigger'>Unlimited cycles<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <div class="square-unchecked trigger-box trigger mb-1 mt-2"></div>
</div>
<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $form }}max_uses">Usage limit<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="number" name="max_uses" id="{{ $form }}max_uses" class="form-control effect-1" placeholder="Usage limit" min="0">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-6 d-none">
    <label for ="{{ $form }}num_uses">Number of uses<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6 d-none">
    <input type="number" name="num_uses" id="{{ $form }}num_uses" class="form-control effect-1" placeholder="Number of uses" min="0" value='0'>
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $form }}stackable">Stackable<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    {{ Form::select('stackable', ['' => ''] + $stackable, null, ['id' => $form.'stackable', 'class' => 'form-control effect-1']) }}
</div>
<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $form }}start_date">Coupon starts</label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="text" name="start_date" id="{{ $form }}start_date" class="form-control effect-1 start_date" placeholder="Coupon Starts">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $form }}end_date">Coupon ends</label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="text" name="end_date" id="{{ $form }}end_date" class="form-control effect-1 end_date" placeholder="Coupon Ends">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6 multiline_min">
    <label for ="{{ $form }}multiline_min">Multiline minimum</label>
</div>
<div class="form-group col-sm-12 col-md-6 multiline_min">
    <input type="number" name="multiline_min" id="{{ $form }}multiline_min" class="form-control effect-1" placeholder="Multiline Minimum" min="0">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6 multiline_max">
    <label for ="{{ $form }}multiline_max">Multiline maximum</label>
</div>
<div class="form-group col-sm-12 col-md-6 multiline_max">
    <input type="number" name="multiline_max" id="{{ $form }}multiline_max" class="form-control effect-1" placeholder="Multiline Maximum" min="0">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6 multiline_restrict_plans">
    <label for="{{ $form }}multiline_restrict_plans">Multiline Plan type Restriction</label>
</div>
<div class="form-group col-sm-12 col-md-6 multiline_restrict_plans">
    <input type="text" name="multiline_restrict_plans" id="{{ $form }}multiline_restrict_plans" class="form-control effect-1 multiline_restrict_plans_addon" placeholder="">
    <span class="focus-border"></span>
</div>