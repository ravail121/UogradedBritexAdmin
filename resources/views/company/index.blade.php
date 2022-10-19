@extends('layouts._app-auth')

@section('page-title')
    Create Company
@endsection

@section('content')
<div class="container">
	<form id ="create-company-form" method="post"
		  action="{{ route('create.company') }}"
		  enctype="multipart/form-data">
        <div class="row">
        	{{ csrf_field() }}
            @include('company.partials._general_info_form')
            @include('company.partials._email_setting_form')
			@include('company.partials._company_information_form')
			@include('company.partials._usaepay_information_form')
			@include('company.partials._ready_cloud_information_form')
			@include('company.partials._shipping_easy_information_form')
			@include('company.partials._carrier_credentials_form')
			@include('company.partials._reselleraccount_status_form')
			@include('company.partials._staff_account_form')
			@include('company.partials._invoice_branding_form')
            <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                <button type="submit" class="btn lightbtn2">Submit</button>
            </div>
        </div>
    </form>
</div>

@endsection

@push('js')
<script>
	$(function(){
	    $('#create-company-form').validate({
	        rules: {
	            name:               	"required",
	            url:                	"required",
	            "carrier_id[]":         "required",
	            default_voice_reg_fee: {
					number:       true
				},
	            default_data_reg_fee: {
					number:       true
				},
	            support_phone_number: {
					number:       true 
				},
	            support_email: {
                    required:  true,
                    email:     true,
                    
                },
	            suspend_grace_period: {
					number:       true
				},
				primary_contact_phone_number: {
					number:       true 
				},
				primary_contact_email_address:{
                    email:     true,
                },
				zip: {
					number:       true ,
					minlength:    5,
					maxlength:    5,
				},
				staff_first_name: {
					required:  true,
				},
				staff_last_name: {
					required:  true,
				},
				staff_email: {
					required:  true,
					email:     true,
					remote: {
						url: "{{ route('check.master.staff.email') }}",
						data: {
							email: function() {
								return $("#staff-email").val();
							}
						},
						type: "post"
					}
				},
				staff_phone: {
					required:   true,
					number:     true,
				},
				staff_password: {
	            	required: true,
					minlength:  6,
				},
				staff_password_confirmation: {
					required: true,
					equalTo:  '#staff-password'
				},
				invoice_background_text_color: 'required',
				invoice_normal_text_color: 'required',
				invoice_account_summary_primary_color: 'required',
				invoice_account_summary_secondary_color: 'required'

	        },
	        messages: {
	            name:              		"Please provide Company Name",
	            usaepay_api_key: {
	                required:          "Please enter your email address",
	                remote:            "Usaepay API Key Already exist"
	            },
				staff_first_name:     	"Please provide First Name.",
				staff_last_name:        "Please provide Last Name.",
				staff_password: {
					required:          "Please provide Password",
					minlength:         "Your password must be at least 6-characters long"
				},
				staff_email: {
					required:          "Please enter your email address",
					email:             "Please enter a valid email address",
					remote:            "Email Already exist"
				},
				invoice_background_text_color: 'Please provide Background Text Color for Invoice Branding',
				invoice_normal_text_color: 'Please provide Normal Text Color for Invoice Branding',
				invoice_account_summary_primary_color: 'Please provide Primary Color for Account Summary section of Invoice Branding',
				invoice_account_summary_secondary_color: 'Please provide Secondary Color for Account Summary section of Invoice Branding',
	        },

	        errorElement: "em",

	        errorPlacement: function( error, element ){

	            $(element).addClass('is-invalid');
	            error.addClass('card-error');
	            error.insertAfter(element);
	        },
	        success: function( label, element ){
	            $(element).removeClass("is-invalid");
	        },
	    });

	    $('#carrier_id').change(function() {
	    	let carriers = $(this).val();
            $('.tmo').addClass('display-none');
            $('.att').addClass('display-none');
            carriers.forEach(function(element){
            let carrier = JSON.parse(element);
    	    	if(carrier.slug == 't-mobile'){
    	    		$('.tmo').removeClass('display-none');
    	    	}else if(carrier.slug == 'at&t'){
    	    		$('.att').removeClass('display-none');
    	    	}
            });
	    });

		$('.invoice-branding-color-picker').colorpicker();

		// When reset is clicked
		$(".reset-color-selection").click(function(e) {
			e.preventDefault();
			var defaultColor = e.target.dataset.defaultValue;
			$(this).parent().siblings('.invoice-branding-color-picker').colorpicker('setValue', defaultColor);
			$(this).parent().siblings('.invoice-branding-color-picker').val(defaultColor);
		});
    });
</script>
@endpush

