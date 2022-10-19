<div class="tab-pane fade" id="acinfo" role="tabpanel" aria-labelledby="acinfo-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src="{{ asset('theme/img/active_img.png') }}" width="11" height="11" alt=""/></span>Shipping Information</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="btns">
                        <button type="button" class="btn btn2 btn-dark shipping-info-save-btn"><span class="fas fa-save"></span>Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="acountinfoform">
                <form id="shipping-info-form" >
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-3">
                            <label for="shipping_fname">First Name<span class="text-danger"> *</span></label>
                            <input type="text" id="shipping_fname" name="shipping_fname" class="form-control effect-1" aria-describedby="emailHelp" placeholder="First Name" value="{{ $customer->shipping_fname }}">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="shipping_lname">Last Name<span class="text-danger"> *</span></label>
                            <input type="text" id="shipping_lname" name="shipping_lname" class="form-control effect-1" aria-describedby="emailHelp" placeholder="Last Name" value="{{ $customer->shipping_lname }}">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="shipping_address1">Address Line 1<span class="text-danger"> *</span></label>
                            <input type="text" id="shipping_address1" name="shipping_address1" class="form-control effect-1" aria-describedby="emailHelp" placeholder="Address Line 1" value="{{ $customer->shipping_address1 }}">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="shipping_address2">Address Line 2</label>
                            <input type="text" id="shipping_address2" name="shipping_address2" class="form-control effect-1" aria-describedby="emailHelp" placeholder="Address Line 2" value="{{ $customer->shipping_address2 }}">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="shipping_city">City<span class="text-danger"> *</span></label>
                            <input type="text" id="shipping_city" name="shipping_city" class="form-control effect-1" aria-describedby="emailHelp" placeholder="City" value="{{ $customer->shipping_city }}">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="shipping_state_id">State<span class="text-danger"> *</span></label>
                            {!! Form::select('shipping_state_id', $states, $customer->shipping_state_id, ['class' => 'custom-select effect-1']) !!}
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="shipping_zip">Zip Code<span class="text-danger"> *</span></label>
                            <input type="text" id="shipping_zip" name="shipping_zip" class="form-control effect-1" aria-describedby="emailHelp" placeholder="Zip" maxlength="5" value="{{ $customer->shipping_zip }}">
                            <span class="focus-border"></span>
                        </div>

                            <div class="form-group col-sm-12 col-md-3">
                            <label for="exampleInputEmail1">Country:</label>
                            <select class="custom-select effect-1" id="exampleFormControlSelect3">
                                <option class="usflag">United States</option>
                            </select>
                            <span class="focus-border"></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>

    $('.shipping-info-save-btn').on('click', function() {
        validateShippingInfo();
        if ($('#shipping-info-form').valid()) {
            updateShippingInfo();
        }
    });

    function updateShippingInfo() {
        let formData = $('#shipping-info-form').serialize();
        $.ajax({
            type: 'POST',
            url: '{{ route('update.shipping.info', $customer->id) }}',
            dataType: 'json',
            data:formData,
            beforeSend: showLoader,
            success: function (data) {
                swal("Success!",'Customer Details Updated!' , "success"); 
            },
            complete: hideLoader,
            error: function (xhr,status,error) {
                firstXhrError(xhr);
            }
        });
    }

    function validateShippingInfo() {
        $('#shipping-info-form').validate({
            rules: {
                shipping_fname:     "required",
                shipping_lname:     "required",
                shipping_address1:  "required",
                shipping_city:      "required",
                shipping_zip: {
                  required:     true,
                  number:       true,
                  minlength:    5,
                },
            },
            messages: {
                shipping_zip: {
                    required:      "Please enter Zip",
                    number:        "Zip field can only have numeric value"
                },
                shipping_city:     "Please provide City",
                shipping_fname:    "Please provide First Name",
                shipping_lname:    "Please provide Last Name",
                shipping_address1: "Please provide Address",
            },

            errorElement: "em",

            errorPlacement: function( error, element ){

                $(element).addClass('is-invalid');
                error.addClass('card-error');
                error.insertAfter(element);
                hideLoader();
            },
            success: function( label, element ){
                $(element).removeClass("is-invalid");
            },
        });
    }
    
</script>

@endpush