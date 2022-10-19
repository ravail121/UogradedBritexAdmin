<div class="form-group col-sm-12 col-md-4">
    <label for ="{{ $form }}-type">Type<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8">
    {{ Form::select('product_type', ['sim' => 'Sim', 'device' => 'Device'], null, ['id' => $form . '-type', 'class' => 'form-control effect-1']) }}
</div>

<div class="form-group col-sm-12 col-md-4 {{ $form }}-sim-product-wrapper">
    <label for ="{{ $form }}-sim-product">Product<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8 {{ $form }}-sim-product-wrapper">
    {{ Form::select('product_id', $simProducts, null, ['id' => $form . '-sim-product', 'class' => 'form-control effect-1']) }}
</div>
<div class="form-group col-sm-12 col-md-4 display-none {{ $form }}-device-product-wrapper">
    <label for="{{ $form }}-device-product">Product<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-8 display-none {{ $form }}-device-product-wrapper">
    {{ Form::select('', $deviceProducts, null, ['id' => $form . '-device-product', 'class' => 'form-control effect-1']) }}
</div>
