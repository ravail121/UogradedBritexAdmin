<div class="form-group col-sm-12 col-md-12">
    <h3 class="text-center">Staff Account</h3>
</div>
<div class="form-group col-sm-12 col-md-3">
    <label for="staff-first-name">First Name<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="staff_first_name" id="staff-first-name" class="form-control effect-1">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="staff-last-name">Last Name<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="staff_last_name" id="staff-last-name" class="form-control effect-1">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="staff-level">Access Level<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-3">
    {{ Form::select('staff_level',['2'=>'Can do everything for this company', '3' => 'Can ONLY access','4' => 'Customer Service rep' ] , null, ['id' => 'staff-level', 'class' => 'form-control effect-1']) }}
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="staff-phone">Phone Number<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="staff_phone" id="staff-phone" class="form-control effect-1">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="staff-email">Email Address<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="text" name="staff_email" id="staff-email" class="form-control effect-1">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-3">
    <label for="staff-password">Password<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="password" name="staff_password" id="staff-password" class="form-control effect-1">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-3">
    <label for="staff-password-confirmation">Confirm Password<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-3">
    <input type="password" name="staff_password_confirmation" id="staff-password-confirmation" class="form-control effect-1">
    <span class="focus-border"></span>
</div>