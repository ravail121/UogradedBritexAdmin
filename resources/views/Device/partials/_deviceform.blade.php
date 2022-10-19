<div class="form-group col-sm-12 col-md-4">
    <label for ="{{ $form }}name">Name<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="name" id="{{ $form }}name" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for ="{{ $form }}sku">SKU</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="sku" id="{{ $form }}sku" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label>Type<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('type', ['' => ''] + $type, null, ['id' => 'type', 'class' => 'form-control effect-1']) }}
</div>


<div class="form-group col-sm-12 col-md-4">
    <label>Tag</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('tag_id', ['' => ''] + $tag->toArray(), null, ['id' => $form.'tag_id', 'class' => 'form-control effect-1']) }}
</div>


<div class="form-group col-sm-12 col-md-4">
    <label>Carrier<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('carrier_id', $carrier, null, ['id' => 'carrier_id', 'class' => 'form-control effect-1']) }}
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label>Additional Carrier</label>
</div>
<div class="form-group col-sm-12 col-md-8">
     <input type="text" name="additional_carrier" id="additional_carrier" class="form-control effect-1 additional_carrier" placeholder="">
</div>

<div class="form-group col-sm-12 col-md-12">
    <label for= "description"> Product Description:-</label>
</div>
<div class="form-group col-sm-12 col-md-12 description">
    <textarea name="description" id="description">
    </textarea>
    <p id="notes-error" class="error card-error description-error display-none">Please provide Description</p>
</div>

<div class="form-group col-sm-12 col-md-12">
    <label for= "description_detail">Description Detail:-</label>
</div>
<div class="form-group col-sm-12 col-md-12 description_detail">
    <textarea name="description_detail" id="description_detail">

    </textarea>
    <p id="notes-error" class="error card-error description_detail-error display-none">Please provide Description Detail</p>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}notes">Notes</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="notes" id="{{ $form }}notes" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-6">
    <div class="row">
        <div class="form-group col-sm-8 col-md-8">
            <label for="primary_image">Upload Product Icon</label>
        </div>
        <div class="form-group col-sm-4 col-md-4 device-image">
            {{-- <img class="" data-toggle="modal" data-target="#device-image" src=""> --}}
        </div>
    </div>
</div>
<div class="form-group col-sm-12 col-md-6">
        <input type="file" name="primary_image" id="primary_image" class="form-control effect-1" placeholder="">
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="primary_image">Upload Product Image</label>
</div>
<div class="form-group col-sm-12 col-md-8">
        <button type="button" data-toggle="modal" data-target="#product-image" class="btn btn-info more-btn">Upload Product Image</button>
</div>


<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}amount">Amount<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="amount" id="{{ $form }}amount" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}amount_w_plan">Amount With Plan<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="amount_w_plan" id="{{ $form }}amount_w_plan" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}shipping_fee">Shipping Fee<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="shipping_fee" id="{{ $form }}shipping_fee" class="form-control effect-1" placeholder="" value = "0">
    <span class="focus-border"></span>
</div>


<div class="form-group col-sm-12 col-md-4">
    <label>Associate with Plan</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('associate_with_plan', [''=>'','0' => 'Do NOT ask user to choose a plan', '1' => 'Require user to select a plan or choose no plan', '2' => 'Require use to choose a plan After added to order'], null, ['id' => 'associate_with_plan', 'class' => 'form-control effect-1']) }}
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for ="vos">Operating System</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="os" id="{{ $form }}os" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}show">Show<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('show', $show, 1, ['id' => $form.'show', 'class' => 'form-control effect-1']) }}
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="show">Device Group Name</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('device_group', [''=>'']+$deviceGroupName, null, ['id' => 'device_group', 'class' => 'form-control effect-1']) }}
</div>

<div class="form-group col-sm-12 col-md-4">
    <label>Device to Plan</label>
</div>
<div class="form-group col-sm-12 col-md-8">
     <input type="text" name="device_to_plan" id="device_to_plan" class="form-control effect-1 device_to_plan">
</div>

<div class="form-group col-sm-12 col-md-4">
    <label>Device to SIM</label>
</div>
<div class="form-group col-sm-12 col-md-8">
     {{-- <input type="text" name="device_to_sim" id="device_to_sim" class="form-control effect-1 device_to_sim"> --}}
     <select name="device_to_sim" id="device_to_sim" class='form-control effect-1 device_to_sim'>
     </select>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for ="sort">Sort</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="sort" id="sort" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $form }}weight">Weight (In Ounces)</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="weight" id="{{ $form }}weight" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
    <div class="col-sm-6 col-md-2">
        <input type="checkbox" class="edit-device-checkbox" name="taxable" id="{{ $form }}taxable" value="1" checked>
    </div>
    <div class="col-sm-6 col-md-10 checkbox-label">
        <label class="" for ="{{ $form }}taxable">Taxable<span class="text-danger"> *</span></label>
    </div>
    </div>
</div>




{{-- <div class="form-group col-sm-6 col-md-6">
    <div class="row">
    <div class="col-sm-6 col-md-2">
        <input type="checkbox" class="edit-device-checkbox" name="affiliate_credit" id="{{ $form }}affiliate_credit" value="1">
    </div>
    <div class="col-sm-6 col-md-10 checkbox-label">
        <label class="" for ="{{ $form }}affiliate_credit">Given Affiliate Credit</label>
    </div>
    </div>
</div> --}}