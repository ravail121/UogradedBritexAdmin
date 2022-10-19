<div class="form-group col-sm-12 col-md-4">
    <label for ="{{ $type }}name">Name<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="name" id="{{ $type }}name" class="form-control effect-1" placeholder="Name">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for ="{{ $type }}sku">SKU</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="sku" id="{{ $type }}sku" class="form-control effect-1" placeholder="SKU">
    <span class="focus-border"></span>
</div>


<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $type }}carrier">Carrier<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('carrier_id', $carrier, null, ['id' => 'carrier_id', 'class' => 'form-control effect-1']) }}
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-12">
    <label for= "description">Description:-</label>
</div>
<div class="form-group col-sm-12 col-md-12">
    <textarea name="description" id="description">
    </textarea>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for ="{{ $type }}note">Notes</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="notes" id="{{ $type }}notes" class="form-control effect-1" placeholder="Notes">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-6">
    <div class="row">
        <div class="form-group col-sm-6 col-md-6">
            <label for="image">Product Icon</label>
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
    <label for="{{ $type }}amount_alone">Amount<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="amount_alone" id="{{ $type }}amount_alone" class="form-control effect-1" placeholder="Amount">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $type }}amount_w_plan">Amount With Plan<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="amount_w_plan" id="{{ $type }}amount_w_plan" class="form-control effect-1" placeholder="Amount With Plan">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $type }}shipping_fee">Shipping Fee<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="shipping_fee" id="{{ $type }}shipping_fee" class="form-control effect-1" placeholder="Shipping Fee" value = "0">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $type }}code">SIM Code</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="code" id="{{ $type }}code" class="form-control effect-1" placeholder="SIM Code">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $type }}show">Show<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('show', [
        0 => 'Visible and orderable with plan inside plan modal',
        1 => 'Visible and orderable with plan and as standalone product',
        2 => 'Show coming soon as standalone product but orderable with plan',
        3 => 'Not visible at all'
    ], 1, ['id' => $type.'show', 'class' => 'form-control effect-1']) }}
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
    <div class="col-sm-6 col-md-2">
        <input type="checkbox" class="edit-product-checkbox" name="taxable" id="{{ $type }}taxable" value="1" checked>
    </div>
    <div class="col-sm-6 col-md-4 checkbox-label">
        <label class="" for ="{{ $type }}taxable">Taxable</label>
    </div>
    </div>
</div>