<div class="form-group col-sm-12 col-md-3">
    <label for="{{ $form }}section">Section<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-9">
    {{ Form::select('section', ['' =>'Please Select Section']+$section, null, ['id' => $form.'section', 'class' => 'form-control effect-1']) }}
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="{{ $form }}name">Name<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-9">
    <input type="text" name="name" id="{{ $form }}name" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="{{ $form }}subject">Subject<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-9">
    <input type="text" name="subject" id="{{ $form }}subject" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-12">
    <label for="body">Body<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-12">
    <textarea name="body" id="body">

    </textarea>
    <p id="notes-error" class="error card-error body-error display-none">Please provide email body</p>
</div>

<div class="form-group col-sm-12 col-md-12">
    <label>Placeholders:-</label>
</div>

<div class="form-group col-sm-12 col-md-12">
    <p>These placeholders can be used in the Email Body</p>
    <span id='placeholder' data-row=""></span>
    <span class="dynamicFields">
         <div class="dropdown display-none place-holderdata business">
            <p class="dropdown-toggle table-btn cursor-pointer" type="button" data-toggle="dropdown">
                <span id="selected_biz_placeholder">biz-verification</span> <span class="caret"></span>
            </p>
            <ul class="dropdown-menu column-name">
                @foreach($businessVerificationTable as $business)
                    <li class="d-flex justify-content-between">
                        <div id="selected_buisiness_text">[business_verification__{{ $business }}]</div>
                        <div class="btn btn-sm"
                             onclick="copyTextToClipboard('[business_verification__' + '{{  $business }}' + ']')">
                            Copy
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="dropdown display-none place-holderdata customer">
            <p class="dropdown-toggle table-btn cursor-pointer" type="button" data-toggle="dropdown">
                <span id="selected_customer_placeholder">customer</span><span class="caret"></span>
            </p>
            <ul class="dropdown-menu column-name">
                @foreach($customerTable as $customer)
                    <li class="d-flex justify-content-between">
                        <div id="selected_customer_text">[customer__{{ $customer }}]</div>
                        <div class="btn btn-sm"
                             onclick="copyTextToClipboard('[customer__' + '{{  $customer }}' + ']')">Copy</div>
                    </li>
                @endforeach
            </ul>
        </div>
    <span>
</div>

<script>
    function placeHolderSelected(dynamicText) {
        if (document.getElementById('selected_biz_placeholder')) {
            document.getElementById('selected_biz_placeholder').textContent = dynamicText;
            $('#add-email-template-form')
                .find('#selected_biz_placeholder').text(dynamicText)
        }
        if (document.getElementById('selected_customer_placeholder')) {
            document.getElementById('selected_customer_placeholder').textContent = dynamicText;
            $('#add-email-template-form')
                .find('#selected_biz_placeholder').text(dynamicText)
        }
    }
</script>
