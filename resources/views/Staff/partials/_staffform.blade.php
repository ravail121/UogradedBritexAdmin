<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $type }}name">First Name<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="text" name="fname" id="{{ $type }}fname" class="form-control effect-1" placeholder="First Name">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $type }}lname">Last Name<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="text" name="lname" id="{{ $type }}lname" class="form-control effect-1" placeholder="Last Name">
    <span class="focus-border"></span>
</div>


<div class="form-group col-sm-12 col-md-6">
    <label for="{{ $type }}level">Access Level<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    {{ Form::select('level',['2'=>'Can do everything for this company', '3'=>'Can ONLY access','4' => 'Customer Service rep' ] , null, ['id' => 'level', 'class' => 'form-control effect-1']) }}
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-6">
    <label for ="{{ $type }}phone">Phone Number<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="text" name="phone" id="{{ $type }}phone" class="form-control effect-1" placeholder="Phone Number">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-6">
    <label for="{{ $type }}carrier">Email Address<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="text" name="email" id="{{ $type }}email" class="form-control effect-1" placeholder="Email">
    <span class="focus-border"></span>
</div>
<div class="form-group col-sm-12 col-md-6">
    <label for="{{ $type }}password">Password<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="password" name="password" id="{{ $type }}password" class="form-control effect-1" placeholder="Password">
    <span class="focus-border"></span>
</div>

<div class="form-group col-sm-12 col-md-6">
    <label for="{{ $type }}password_confirmation">Confirm Password<span class="text-danger"> *</span></label>
</div>
<div class="form-group col-sm-12 col-md-6">
    <input type="password" name="password_confirmation" id="{{ $type }}password_confirmation" class="form-control effect-1" placeholder="Confirm Password">
    <span class="focus-border"></span>
</div>