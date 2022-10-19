@extends('layouts._app-auth')

@section('page-title')
    Edit Company
@endsection

@section('content')
<div class="container">
	<form id ="edit-company-form" method="post" action="{{ route('update.company', $company->id) }}" 
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
			@include('company.partials._invoice_branding_form')
            <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                <button type="submit" class="btn lightbtn2">Update</button>
            </div>
        </div>
    </form>
</div>

@endsection

@push('js')
<script>
	$(function(){
        carrierChange();
	    $('#edit-company-form').validate({
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
	            support_email:{
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
				invoice_background_text_color: 'required',
				invoice_normal_text_color: 'required',
				invoice_account_summary_primary_color: 'required',
				invoice_account_summary_secondary_color: 'required'
	        },
	        messages: {
	            name:         "Please provide Company Name",
	            usaepay_api_key: {
	                remote:   "Usaepay API Key Already exist"
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

	    $('#carrier_id').change(carrierChange);

        function carrierChange() {
            var carriers = $('#carrier_id').val();
            $('.tmo').addClass('display-none');
            $('.att').addClass('display-none');
            carriers.forEach(function(element){
				var carrier = JSON.parse(element);
                if(carrier.slug === 't-mobile'){
                    $('.tmo').removeClass('display-none');
                }else if(carrier.slug === 'at&t'){
                    $('.att').removeClass('display-none');
                }else if(carrier.slug === 'ultra'){
					$('.ultra').removeClass('display-none');
				}
            });
        }
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

