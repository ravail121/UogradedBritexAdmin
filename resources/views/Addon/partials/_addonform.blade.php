<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $type }}name">Name<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="name" id="{{ $type }}name" class="form-control effect-1" placeholder="Addon Name">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $type }}sku">SKU</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="sku" id="{{ $type }}sku" class="form-control effect-1" placeholder="SKU">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-12">
    <label>Description<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-12">
    <textarea name="description" id="description">
    </textarea>
    <p id="notes-error" class="error card-error description-error display-none">Please provide Description</p>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $type }}notes">Notes</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="notes" id="{{ $type }}notes" class="form-control effect-1" placeholder="Note">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $type }}amount_recurring">Amount Recurring<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="amount_recurring" id="{{ $type }}amount_recurring" class="form-control effect-1" placeholder="Amount">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label>SOC Code.</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input for="{{ $type }}soc_code" type="text" name="soc_code" id="{{ $type }}soc_code" class="form-control effect-1" placeholder="SOC Code">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $type }}bot_code">BOT Code.</label>
</div>
<div class="form-group col-sm-12 col-md-8">
    <input type="text" name="bot_code" id="{{ $type }}bot_code" class="form-control effect-1" placeholder="BOT Code">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-4">
    <label for="{{ $type }}show">Show<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('show', $show, 1, ['id' => $type.'show', 'class' => 'form-control effect-1']) }}
</div>

<div class="form-group col-sm-6 col-md-6">
    <div class="row">
    <div class="col-sm-6 col-md-2">
        <input type="checkbox" class="edit-device-checkbox" name="taxable" id="{{ $type }}taxable" value="1" checked>
    </div>
    <div class="col-sm-6 col-md-4 checkbox-label">
        <label for ="{{ $type }}taxable">Taxable<span class="text-danger"> *</span></label>
    </div>
    </div>
</div>