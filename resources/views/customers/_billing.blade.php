<div class="tab-pane fade" id="billing" role="tabpanel" aria-labelledby="billing-tab">
<div class="billingbx">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <h1><span><img src="{{ asset('theme/img/active_img.png') }}" alt="" width="11" height="11"></span>Billing Details</h1>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-8 text-right"> </div>
        </div>
    </div>
    <div class="billing_form1">
    <div class="acountinfoform">
        <div class="row">
            <div class="form-group col-sm-12 col-md-3 enablebtn">
                <label for="exampleInputEmail1">Enable Auto Pay?</label>
                <label class="switch">
                    {!! Form::checkbox('1','1', $customer->auto_pay , ['name' => 'auto', 'id' => 'autopay', 'class'=>'auto-pay']) !!}
                    <span class="slider round"></span>
                </label>
                {!! Form::hidden(null,1, ['name' => 'auto_pay', 'id' => 'auto-pay']) !!}
                <p>Enabled</p>
            </div>
            <div class="form-group col-sm-12 col-md-3" style="padding-top: 10px;">
                <div class="addnotes">
                    <a href="#addmethodpop" data-toggle="modal" data-target="#addmethodpop">
                        <h1><span><img src="{{ asset('theme/img/add_note.png') }}" width="59" height="59" alt=""/></span>Add New Card </h1>
                    </a>
                </div>
            </div>
        </div>
        <form id="billingform">
            <div class="row">
                <div class="form-group col-sm-12 col-md-4 col-alignment">
                    <label for="payment_type">Transaction<span class="text-danger"> *</span></label>
                    {!! Form::select('payment_type', $transactionType, null, ['class' => 'custom-select effect-1', 'id' => "payment_type"]) !!}
                    <span class="focus-border"></span> </div>
                <div class="form-group col-sm-12 col-md-4 card-div" style="overflow: visible !important;">
                    <div class="visacard">
                        <div class="row">
                            <div class="col-sm-4 col-md-4"><img src="{{ asset('theme/img/card_img.png') }}" class="img-fluid cardimg" alt="" /></div>
                            <div class="col-sm-8 col-md-8">
                                <h1 class="card-holder-name">{{ $customer->full_name }}</h1>
                                @if($customerCards->isNotEmpty())
                                    <div id="select-box">
                                        <ul class="faux-select" data-selected-value="ted">
                                            <li class="selected-option effect-1"><strong class="fas fa-credit-card"></strong><span>Please Select a Card</span> <b class="primarytxt"></b>
                                                <ul class="options card-options">
                                                    @foreach($customerCards as $key => $card)
                                                        <li class="" data-name ="{{ $card['cardholder'] }}" data-row ={{ $card['id'] }}>
                                                        <b class=""></b>
                                                        {{ $card['card_type'] }}- {{ $card['last4'] }}
                                                        @if($card['default'])<i class="default-check fas fa-check"></i></li>@endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </ul>
                                        <span class="focus-border"></span>
                                        <p class="card-error no-card-error display-none">Please select a Card</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-12 col-md-4 show-none invoice-type col-alignment">
                    <label for="invoice_type">Invoice Type<span class="text-danger"> *</span></label>
                    {!! Form::select('invoice_type', ['existing' => 'Add to Monthly Invoice','create' => 'Create New Invoice'], null, ['class' => 'custom-select effect-1', 'id' => 'invoice_type']) !!}
                    <span class="focus-border"></span>
                </div>

                <div class="form-group col-sm-12 col-md-4 type show-none billing-type col-alignment">
                    <label for="type">Type<span class="text-danger"> *</span></label>
                    {!! Form::select('type', ['3' => 'One Time','4' => 'Usage Charge'], null, ['class' => 'custom-select effect-1', 'id' => 'usage_type']) !!}
                    <span class="focus-border"></span>
                </div>

                <div class="form-group col-sm-12 col-md-4 account-level col-alignment">
                    <label for="subscription_id">Account Level</label>
                    {!! Form::select('subscription_id', [null => 'Please Select an Active Phone number']+$subcription, null, ['class' => 'custom-select effect-1 subscription_id']) !!}
                    <p class="card-error phone-no-error display-none">Please select a Phone Number</p>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12 col-md-4 col-alignment">
                    <label for="amount">Amount <span class="text-danger"> *</span></label>
                    <input type="text" id="amount" name="amount" class="form-control effect-1" aria-describedby="emailHelp" placeholder="Please Enter Amount">
                    <span class="focus-border"></span>
                </div>

                <div class="form-group col-sm-12 col-md-4 col-alignment">
                    <div class="billing-description display-none">
                        <label for="description">Description<span class="text-danger"> *</span></label>
                        <div class="input-group descriptioninputbx col-sm-12 col-md-7" style="overflow:hidden !important; padding-left:0px !important;">
                            <input type="text" id ="description" name="description" class="form-control effect-1" aria-describedby="emailHelp" placeholder="Write Something...">
                            <span class="focus-border"></span>
                        </div>
                    </div>

                    <div class="finalsendbtn">
                        <button type="submit" class="btn btn1 sendbtn2"><span class="fas fa-location-arrow"></span>Send</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
    </div>
    <div class="pattseprator"></div>
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src="{{ asset('theme/img/active_img.png') }}" width="11" height="11" alt=""/></span>Billing Address Details</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="btns">
                        <button type="button" class="btn btn2 btn-dark billing-info-save-btn"><span class="fas fa-save"></span>Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="acountinfoform">
                <form id="billing-info-form">
                    <div class="row">

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="billing_fname">First Name<span class="text-danger"> *</span></label>
                            <input type="text" class="form-control effect-1" aria-describedby="emailHelp" name="billing_fname" id="billing_fname" value="{{ $customer->billing_fname }}" placeholder="First Name">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="billing_lname">Last Name<span class="text-danger"> *</span></label>
                            <input type="text" class="form-control effect-1" aria-describedby="emailHelp" name="billing_lname" id="billing_lname" value="{{ $customer->billing_lname }}" placeholder="Last Name">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="billing_address1">Address Line 1<span class="text-danger"> *</span></label>
                            <input type="text" class="form-control effect-1" aria-describedby="emailHelp" name="billing_address1" id="billing_address1" value="{{ $customer->billing_address1 }}"  placeholder="Address Line 1">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="billing_address2">Address Line 2</label>
                            <input type="text" name="billing_address2" id="billing_address2" value="{{ $customer->billing_address2 }}"  class="form-control effect-1" aria-describedby="emailHelp">
                            <span class="focus-border"></span>
                        </div>
                        
                        <div class="form-group col-sm-12 col-md-3">
                            <label for="billing_city">City<span class="text-danger"> *</span></label>
                            <input type="text" class="form-control effect-1" aria-describedby="emailHelp" name="billing_city" id="billing_city" value="{{ $customer->billing_city }}" placeholder="City">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="billing_state_id">State<span class="text-danger"> *</span></label>
                            {!! Form::select('billing_state_id', $states, $customer->billing_state_id, ['class' => 'custom-select effect-1']) !!}
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                            <label for="billing_zip">Zip Code<span class="text-danger"> *</span></label>
                            <input type="text" class="form-control effect-1" aria-describedby="emailHelp" name="billing_zip" id="billing_zip" value="{{ $customer->billing_zip }}" placeholder="Zip" maxlength="5">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-3">
                        <label for="exampleInputEmail1">Country:</label>
                        <select class="custom-select effect-1" id="exampleFormControlSelect3">
                            <option class="usflag">United States Of America</option>
                        </select>
                        <span class="focus-border"></span> </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade bd-example-modal-lg" id="addmethodpop" tabindex="-1" role="dialog" aria-labelledby="addmethodpop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close close-add-card" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx">
                        <h1>Add A New Card</h1>
                        <div class="userbx"> <img src="{{ asset('theme/img/card_lg.png') }}" class="img-fluid" alt="" /> </div>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <div class="topdrtxt">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h2>Credit Card Info</h2>
                        </div>
                        <div class="col-sm-12 col-md-6 text-right">
                            <h3><img src="{{ asset('theme/img/cards.png') }}" class="img-fluid" alt=""/></h3>
                        </div>
                    </div>
                </div>
                <form id="add-card-form">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="payment_card_holder">Cardholder’s Name<span class="text-danger"> *</span></label>
                            <input type="text" id="payment_card_holder" name="payment_card_holder" class="form-control effect-1" aria-describedby="emailHelp" placeholder="Please Enter Cardholder’s Name">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="payment_card_no">Card Number<span class="text-danger"> *</span></label>
                            <input type="text" id="payment_card_no" name="payment_card_no" class="form-control effect-1" aria-describedby="emailHelp" placeholder="Please Enter Card New Number">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="expires_mmyy">Expiration Date<span class="text-danger"> *</span></label>
                            <input type="text" id ="expires_mmyy" name="expires_mmyy" class="form-control effect-1" aria-describedby="emailHelp" placeholder="MM/YY" maxlength="5">
                            <span class="focus-border"></span>
                        </div>
                        
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="payment_cvc">CVC Number<span class="text-danger"> *</span></label>
                            <input type="text" id="payment_cvc" name ="payment_cvc" class="form-control effect-1" aria-describedby="emailHelp" maxlength="4" placeholder="CVV">
                            <span class="focus-border"></span> </div>
                    </div>
                    <br>
                    <div class="topdrtxt">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <h2>Billing Info</h2>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="billing_address1">Address Line 1<span class="text-danger"> *</span></label>
                            <input type="text" id="billing_address1" name="billing_address1" class="form-control effect-1" aria-describedby="emailHelp" placeholder="Address Line 1">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="billing_address2">Address Line 2</label>
                            <input type="text" id="billing_address2" name="billing_address2" class="form-control effect-1" aria-describedby="emailHelp" placeholder="Address Line 2">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="billing_city">City<span class="text-danger"> *</span></label>
                            <input type="text" id="billing_city" name ="billing_city" class="form-control effect-1" aria-describedby="emailHelp" placeholder="City">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="billing_state_id">State<span class="text-danger"> *</span></label>
                            {!! Form::select('billing_state_id', $states, null, ['class' => 'custom-select effect-1']) !!}
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="billing_zip">Zip Code<span class="text-danger"> *</span></label>
                            <input type="text" id="billing_zip" name="billing_zip" class="form-control effect-1" aria-describedby="emailHelp" placeholder="" maxlength="5">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6 mt-4">
                            <div class="enablebtn">
                                <label class="switch float-left">
                                    <input type="checkbox" id="default" name="default">
                                    <span class="slider round"></span>
                                </label>
                                <p>Make Primary</p>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 col-md-12  mt-4 text-center">
                            <button type="submit" class="btn lightbtn"><span class="fas fa-plus"></span>Add New Card</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>

    $('body').on('click','.card-options li', function() {
        let $this = $(this);
        $('.card-options .selected').removeClass('selected')
        $this.addClass('selected');
        $('.card-options li .fa-check').removeClass('fas fa-check')
        $this.find('b').addClass('fas fa-check');
        $('.card-holder-name').text($this.attr('data-name'));
    });

    $('#billingform').on('submit',function (e){
        e.preventDefault();
        validateMutualPayment();
        if ($('#billingform').valid()) {
            let payment_type = $('#payment_type').val()
            if(payment_type == 'Manual Credit'){
                manualCredit();
            }else if(payment_type == 'Custom Invoice'){
                customInvoice();
            }
            else{
                let cardId;
                let error = 0;
                if(cardId = $('.card-options .selected').attr('data-row')){
                    $('.no-card-error').addClass('display-none')
                }else{
                    $('.no-card-error').removeClass('display-none');
                    error++;
                }
                if(error == 0){
                    manualPayment(cardId);
                }
            }
        } 
    })

    $('body').on('change','#payment_type', hideFields);

    $(window).on('load', function(){
        hideFields();
    });

    // $('body').on('change','#invoice_type', hideTypeFields);

    function hideFields() {
        $('.show-none').removeClass('show-none');
        $('.billing-description').removeClass('display-none');
        let payment_type = $('#payment_type').val();
        if(payment_type == 'Manual Payment'){
            $('.billing-type').addClass('show-none');
            $('.billing-description').addClass('display-none');
            $('.invoice-type').addClass('show-none');
            if($('.col-alignment').hasClass('col-md-6')){
                $('.col-alignment').removeClass('col-md-6').addClass('col-md-4');
            }
        }else if(payment_type == 'Custom Charge'){
            $('.billing-type').addClass('show-none');
            $('.invoice-type').addClass('show-none');
            // $('.account-level').addClass('show-none');
            if($('.col-alignment').hasClass('col-md-6')){
                $('.col-alignment').removeClass('col-md-6').addClass('col-md-4');
            }
        }else if(payment_type == 'Custom Invoice'){
            $('.card-div').addClass('show-none');
            $('.invoice-type').removeClass('show-none');
            if($('.col-alignment').hasClass('col-md-4')){
                $('.col-alignment').removeClass('col-md-4').addClass('col-md-6');
            }
        }else{
            $('.card-div').addClass('show-none');
            $('.billing-type').addClass('show-none');
            $('.account-level').addClass('show-none');
            $('.invoice-type').addClass('show-none');
            if($('.col-alignment').hasClass('col-md-6')){
                $('.col-alignment').removeClass('col-md-6').addClass('col-md-4');
            }
        }
    }

    function hideTypeFields() {
        var invoiceType = $('#invoice_type').val();
        if(invoiceType === 'create'){
            $('.billing-type').addClass('show-none');
        } else {
            $('.billing-type').removeClass('show-none');
        }

    }

    function customInvoice() {
        let formData = $('#billingform').serialize();
        $.ajax({
            type: 'POST',
            url: '{{ route('custom.invoice', $customer->id) }}',
            dataType: 'json',
            data:formData,
            beforeSend: showLoader,
            success: function (data) {
                if(data.hasOwnProperty('error')) {
                    swal("Error!", data.error, "error");
                } else{
                    swal("Success!", 'Custom invoice created' , "success");
                }
                hideFields();
            },
            complete: hideLoader,
            error: function (xhr, status, error) {
                firstXhrError(xhr);
            }
        });
    }


    function manualCredit() {
        let formData = $('#billingform').serialize();
        $.ajax({
            type: 'POST',
            url: '{{ route('manual.credit', $customer->id) }}',
            dataType: 'json',
            data:formData,
            beforeSend: showLoader,
            success: function (data) {
                swal("Success!",'Payment Sucessfull!' , "success");
                $('#billingform')[0].reset();
                hideFields();
            },
            complete: hideLoader,
            error: function (xhr,status,error) {
                firstXhrError(xhr);
            }
        });
    }
    

    function manualPayment(cardId) {
        let formData = $('#billingform').serialize();
        formData =  formData + '&credit_card_id='+cardId;
        $.ajax({
                type: 'POST',
                url: '{{ route('manual.payment', $customer->id) }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    if(data.message){
                        swal("Error!",'Payment Decline Due To'+data.message , "error");    
                    }else{
                        swal("Success!",'Payment Successful!' , "success");
                    }
                    $('#billingform')[0].reset();
                    hideFields();
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
    }

    $('.auto-pay').on('change', toggleCheckbox);

    function toggleCheckbox(f){
        const value = $(this).is(':checked') ? 1 : 0;
        $('#auto-pay').val(value);
        updateAutopay()            
    };

    function updateAutopay() {
        $.ajax({
            type: 'POST',
            url: '{{ route('update.autopay', $customer->id) }}',
            dataType: 'json',
            data: { auto_pay: $('#auto-pay').val() },
            beforeSend: showLoader,
            success: function (data) {

            },
            complete: hideLoader,
            error: function (xhr,status,error) {
                firstXhrError(xhr);
            }
        });
    }
    $('#payment_card_no').inputmask("mask", {"mask": "9999 9999 9999 9999 999", placeholder:"", clearIncomplete: false});
    $('#expires_mmyy').inputmask({ alias: "datetime", inputFormat: "mm/yy", clearIncomplete: true });

    $('#add-card-form').on('submit',function (e){
        e.preventDefault();
        validateCard();
        if ($('#add-card-form').valid()) {
            addCardAjax();
        } 
    })

    function addCardAjax() {
        const formData = $('#add-card-form').serialize();
        $.ajax({
            type: 'POST',
            url: '{{ route('add.card', $customer->id) }}',
            dataType: 'json',
            data:formData,
            beforeSend: showLoader,
            success: function (data) {
                if(data.message){
                    swal("Error!",'Card Decline Due to '+data.message , "error");    
                }else{
                    swal("Success!",'Card Added Successfully' , "success"); 
                }
                $('#add-card-form')[0].reset();
            },
            complete: hideLoader,
            error: function (xhr,status,error) {
                firstXhrError(xhr);
            }
        });
    }

    function validateMutualPayment() {
        $('#billingform').validate({
            rules: {
                amount: {
                  required:     true,
                  number:       true 
                },
                subscription_id: {
                    required: function(element) {
                        var usage_type = $('#usage_type').val()
                        var payment_type = $('#payment_type').val()
                        return payment_type === 'Custom Invoice' && usage_type == 4
                    }
                }
                //description:        "required",
            },
            messages: {
                amount: {
                    required:      "Please enter Amount",
                    number:        "Amount field can only have numeric value"
                },
                subscription_id: {
                    required: "Please Select an Active Phone Number"
                }
                //description:   "Please provide Description",
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

    function validateCard() {
        $('#add-card-form').validate({
            rules: {
                payment_card_no: {
                  required:     true,
                  creditcard:   true
                },
                expires_mmyy: {
                    required:   true,
                    CCExp: {
                        expire:          '#expires_mmyy'
                    }
                },
                payment_cvc: {
                  required:     true,
                  number:       true 
                },
                payment_card_holder:   "required",
                billing_address1:      "required",
                billing_city:          "required",
                billing_state_id:      "required",
                billing_zip:           "required",
            },
            messages: {
                payment_card_no: {
                    required:          "Please enter your Card Number",
                    creditcard:        "Please enter a valid Card Number"
                },
                // expires_mmyy:          "Please provide expire year",
                payment_cvc:           "Provide CVV",
                payment_card_holder:   "Please provide Cardholder Name ",
                billing_address1:      "Please provide Address",
                billing_city:          "Please provide City",
                billing_state_id:      "Please provide State",
                billing_zip:           "Please provide Zip",
                
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

    $('.billing-info-save-btn').on('click', function() {
            validateBillingInfo();
            if ($('#billing-info-form').valid()) {
                updateBillingInfo();
            }
        });

    function updateBillingInfo() {
        let formData = $('#billing-info-form').serialize();
        $.ajax({
            type: 'POST',
            url: '{{ route('update.billing.info', $customer->id) }}',
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

    function validateBillingInfo() {
        $('#billing-info-form').validate({
            rules: {
                billing_fname:     "required",
                billing_lname:     "required",
                billing_address1:  "required",
                billing_city:      "required",
                billing_zip: {
                  required:     true,
                  number:       true,
                  minlength:    5,
                },
            },
            messages: {
                billing_zip: {
                    required:      "Please enter Zip",
                    number:        "Zip field can only have numeric value"
                },
                billing_city:     "Please provide City",
                billing_fname:    "Please provide First Name",
                billing_lname:    "Please provide Last Name",
                billing_address1: "Please provide Address",
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

    $.validator.addMethod('CCExp', function(value, element, params) {
        let minMonth = new Date().getMonth() + 1;
        
        var result = $(params.expire).val().split('/');
        let month    = result[0];
        let minYear  = new Date().getFullYear().toString().substr(-2);
        let maxYear  = Number(minYear) +11;
        let year     = result[1];
        return (!month || !year || (year > minYear && year < maxYear) || (year == minYear && month >= minMonth));
    }, 'Expiration date is invalid.');

</script>
@endpush