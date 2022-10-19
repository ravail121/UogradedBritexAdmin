@extends('layouts._app-auth')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
@endpush

@section('page-title')
    Plans
@endsection

@section('content')
<div class="subscbx bgwhite">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
                <h1><span><img src="{{ asset("theme/img/icon_acti.png") }}" width="11" height="11" alt=""/></span>All Plans</h1>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
                <div class="actionbtn"> 
                    <a class="btn markbtn createbtn" href="#createpopup" data-toggle="modal" data-target="#createpopup">Add New</a> 
                </div>
            </div>
        </div>
    </div>
    <div class="subscribersdata">
        <div class="table-responsive">
            <table class="table audittable tablecentertxt" id="all-paln-table">
                <thead>
                    <tr>
                        <th scope="col" class="custom-width">ID</th>
                        <th scope="col">Carrier</th>
                        <th scope="col" class="custom-name-width">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Recurring Price</th>
                        <th scope="col" class="c-w-10">Activation Fee</th>
                        <th scope="col">Live</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Modify</th>
                        <th scope="col" class="display-none"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="updateshipping" tabindex="-1" role="dialog" aria-labelledby="updateshipping" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close edit-model-close-btn" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                        <h1>Edit Plan</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="edit-product-form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="" placeholder="">
                    <div class="row">
                        @include('Plan.partials._planform', ['form' => ''])

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="createpopup" tabindex="-1" role="dialog" aria-labelledby="createpopup" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx margin-bottom40">
                        <h1>Add New Plan</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="add-product-form"  method="post" enctype="multipart/form-data">
                    <div class="row">

                        @include('Plan.partials._planform', ['form' => 'create'])

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">CREATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="product-image" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <div class="modal-body">
            <img class="model-product-image" src="">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<script>
    $(function(){
        loadPlanData()
        $( '.modal' ).modal( {
            focus: false,
            show: false
        } );
        
        $toolbar = [
            ['style', ['style']],
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['Misc', ['codeview']],
        ];

        function loadPlanData() {
            $('#all-paln-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('allplan.datatable') }}",
                    beforeSend: showLoader,
                    complete: hideLoader,
                },
                "language": {
                    "processing": "Please Wait...",
                },
                "columns": [
                    { 
                        "data": 'id',
                        'class' :'text-center',
                    },
                    { 
                        "data": 'carrier',
                        'class' :'text-center',
                    },
                    { "data": 'name' },
                    { "data": 'type' },
                    { "data": 'recurring-price' },
                    { "data": 'activation-fee' },
                    { "data": 'live' },
                    { "data": 'sku' },
                    { 
                        "data": 'modify',
                        "orderable": false,
                    },
                    { 
                        "data": 'all-data',
                        "orderable": false,
                        'class' :'display-none data-row',
                    },
                ]
                
            });
        }

        $('body').on('click', '.edit-btn', function(e) {
            e.preventDefault();
            let data = $(this).parents('tr').find('.data-row').text();
            setValue(data);
        });

        $('body').on('click', '.product-image', function(e) {
            e.preventDefault();
            $('.model-product-image').attr('src', $(this).attr('src'));
        });

        $('body').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Do You really want to delete this Product",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    deleteProduct($(this).attr('data-id')) 
                }
            });
        });

        $('body').on('submit', '#edit-product-form', function(e) {
            e.preventDefault();
            $form = $('#edit-product-form');
            validateForm($form);
            if ($form.valid()) {
                editProduct();
            }
        });

        function setValue(data) {
            data = JSON.parse(data);
            const $form = $('#edit-product-form');
            $form.find('#description').summernote('destroy');
            $form.find('.error').addClass('display-none');
            $form.find('#image').val('');
            $form.find('em').hide();
            $form.find('.is-invalid').removeClass('is-invalid'); 
            $form.find('#id').val(data.id);
            $form.find('#name').val(data.name);
            $form.find('#sku').val(data.sku);
            $form.find('#carrier_id').val(data.carrier_id);
            $form.find('#tag_id').val(data.tag_id);
            $form.find('#area_code').val(data.area_code);
            $form.find('#description').val(data.description);
            $form.find('#amount_recurring').val(data.amount_recurring);
            $form.find('#amount_onetime').val(data.amount_onetime);
            $form.find('#notes').val(data.notes);
            $form.find('#show').val(data.show);
            $form.find('#signup_porting').prop('checked', data.signup_porting);
            $form.find('#subsequent_porting').prop('checked', data.subsequent_porting);
            $form.find('#imei_required').prop('checked', data.imei_required);
            $form.find('#require_device_info').prop('checked', data.require_device_info);
            $form.find('#taxable').prop('checked', data.taxable);
            $form.find('#sim_required').prop('checked', data.sim_required);
            $form.find('#affilate_credit').prop('checked', data.affilate_credit);
            $form.find('#data_limit').val(data.data_limit);
            $form.find('#type').val(data.type);
            $form.find('#rate_plan_soc').val(data.rate_plan_soc);
            $form.find('#rate_plan_bot_code').tagsinput('removeAll');
            $form.find('#rate_plan_bot_code').tagsinput('add', data.rate_plan_bot_code);
            $form.find('#show').val(data.show);
            $form.find('#regulatory_fee_type').val(data.regulatory_fee_type);
            $form.find('#data_soc').val(data.data_soc);
            $form.find('#regulatory_fee_amount').val(data.regulatory_fee_amount);
            $form.find('#associate-with-coupon').val(data.auto_add_coupon_id);
            $form.find('#subsequent_zip').prop('checked', data.subsequent_zip);
            $form.find('#own_sim_card_option').prop('checked', data.own_sim_card_option);
            if(data.image){
                image = '<img class="product-image" data-toggle="modal" data-target="#product-image" src='+data.image+'>';
            }else{
                image ="";
            }
            $form.find('.data-product-image').html(image); 

            $form.find('#plan_data_soc_bot_code').tagsinput('removeAll');
            data.plan_data_soc_bot_code.forEach(function(element) {
                $form.find('#plan_data_soc_bot_code').tagsinput('add', element.data_soc_bot_code);
            });
            
            $form.find('#custom_plan_name').tagsinput('removeAll');
            data.plan_custom_type.forEach(function(element) {
                $form.find('#custom_plan_name').tagsinput('add', element.name);
            });
            
            $form.find('#plan_block').tagsinput('removeAll');
            data.plan_block.forEach(function(element) {
                $form.find('#plan_block').tagsinput('add', element);
            });

            $form.find('#plan_to_addons').tagsinput('removeAll');
            data.plan_to_addon.forEach(function(element) {
                $form.find('#plan_to_addons').tagsinput('add', element);
            });

            $form.find('#description').summernote({
                toolbar: $toolbar,
                height: 200
            });
        }

        function validateForm($form) {
            $form.validate({
                rules: {
                    amount_recurring: {
                      required:     true,
                      number:       true 
                    },
                    amount_onetime: {
                      required:     true,
                      number:       true 
                    },
                    data_limit: {
                      number:       true 
                    },
                    name:                 "required",
                    carrier_id:           "required",
                    type:                 "required",
                    area_code:            "required",
                    regulatory_fee_amount:"required",
                },
                messages: {
                    amount_recurring: {
                        required:      "Please enter Amount",
                        number:        "Amount field can only have numeric value"
                    },
                    amount_onetime: {
                        required:      "Please enter Amount",
                        number:        "Amount field can only have numeric value"
                    },
                    name:               "Please provide Name",
                    data_limit:         "Data lint must be numeric",
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
        }

        function editProduct() {
            let formData = $('#edit-product-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('edit.plan') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $image = $('#edit-product-form').find('#image');
                    if($image.val()){
                        UploadImage(data.id, $image);
                    }else{
                        swal("Success!",'Plan Sucessfully Edited!' , "success");
                        $('.edit-model-close-btn').click();
                        loadPlanData();   
                    }
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        function UploadImage(id, $image = null) {
            let fd = new FormData();
            let files = $image[0].files[0];
            fd.append('image',files);
            fd.append('id',id);
                $.ajax({
                url:"{{ route('upload.plan.image') }}",
                method:"POST",
                data: fd,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(data)
                {
                    swal("Success!",'Plan Details & Image Sucessfully Edited!' , "success");
                    $('.close').click();
                    loadPlanData();
                },
                error: function (data) {
                    swal("Image Not Updated!", "Sorry Something went wrong Plan Image not Upload", "error");
                }
            })
        }

        function deleteProduct(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('delete.plan') }}',
                dataType: 'json',
                data:{id: id },
                beforeSend: showLoader,
                success: function (data) {
                    if(data.error){
                        swal(data.error)
                    }else{
                        swal("Success!",'Plan Deleted Sucessfully!' , "success");
                        loadPlanData();
                    }

                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            })
        }

        $('#add-product-form #description').summernote({
            toolbar: $toolbar,
            height: 200
        });

        let plan_block = new Bloodhound({
          datumTokenizer: Bloodhound.tokenizers.obj.whitespace('display_name'),
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          prefetch: "{{ route('plan.block') }}"
        });
        plan_block.initialize();

        let plan_block_input = $('.plan_block');
        plan_block_input.tagsinput({
            itemValue: 'id',
            itemText: 'display_name',
            typeaheadjs: {
                name: 'plan_block',
                displayKey: 'display_name',
                source: plan_block.ttAdapter(),
            }
        });

        let plan_to_addon = new Bloodhound({
          datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          prefetch: "{{ route('plan-to-addon') }}"
        });
        plan_to_addon.initialize();

        let plan_to_addon_input = $('.plan_to_addon');
        plan_to_addon_input.tagsinput({
            itemValue: 'id',
            itemText: 'name',
            typeaheadjs: {
                name: 'plan_to_addon',
                displayKey: 'name',
                source: plan_to_addon.ttAdapter(),
            }
        });
        $('body').on('submit', '#add-product-form', function(e) {
            e.preventDefault();
            $form = $('#add-product-form');
            validateForm($form);
            if ($form.valid()) {
                addProduct();
            }
        });

        function addProduct() {
            let formData = $('#add-product-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('add.plan') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $image = $('#add-product-form').find('#image');
                    if($image.val()){
                        UploadImage(data.id, $image);
                    }else{
                        swal("Success!",'Plan Sucessfully Added!' , "success");
                        $('.close').click();
                        loadPlanData();   
                    }
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }
    });
</script>
@endpush