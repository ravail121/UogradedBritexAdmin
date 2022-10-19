<div class="form-group col-sm-12 col-md-3">
    <label for ="{{ $form }}code">Code<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-9">
    <select name="code" class="form-control effect-1 code" id="{{$form}}code">
       
        @foreach($systemEmailTemplate as $code)
            <option value="{{$code}}">{{$code}}</option>

        @endforeach
    </select>
</div>
<div class="form-group col-sm-12 col-md-3">
    <label for ="{{ $form }}from">From<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-9">
    <input type="text" name="from" id="{{ $form }}from" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="{{ $form }}to">To<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-9">
    <input type="text" name="to" id="{{ $form }}to" class="form-control effect-1" placeholder="">
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

<div class="form-group col-sm-12 col-md-3">
    <label for="{{ $form }}notes">Notes</label>
</div>
<div class="form-group col-sm-12 col-md-9">
    <input type="text" name="notes" id="{{ $form }}notes" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="{{ $form }}reply_to">Reply To</label>
</div>
<div class="form-group col-sm-12 col-md-9">
    <input type="text" name="reply_to" id="{{ $form }}reply_to" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="{{ $form }}cc">Cc</label>
</div>
<div class="form-group col-sm-12 col-md-9">
    <input type="text" name="cc" id="{{ $form }}cc" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="{{ $form }}bcc">Bcc</label>
</div>
<div class="form-group col-sm-12 col-md-9">
    <input type="text" name="bcc" id="{{ $form }}bcc" class="form-control effect-1" placeholder="">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-12">
    <label>Placeholders:-</label>
</div>
<div class="form-group col-sm-12 col-md-12">
    <p>These table column can be used as placeholders, Click on the table name to see placeholders</p>
    <span id='placeholder' data-row="{{$allPlaceHolders}}"></span>
    <span id='custom-place-holder' data-row="{{$customPlaceHolders}}"></span>
    <span class="dynamicFields"> 
        <p id="codeValues" style="margin-left: 10px; margin-bottom: 0px !important"></p>
    <span>
</div>