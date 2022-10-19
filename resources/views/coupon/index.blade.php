@extends('layouts._app-auth')
@push('css')
    {{-- {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css') !!} --}}
@endpush
@section('page-title')
    Coupons
@endsection

@section('content')
<div class="subscbx bgwhite">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
                <h1><span><img src="{{ asset("theme/img/icon_acti.png") }}" width="11" height="11" alt=""/></span>Coupons</h1>
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
            <table class="table audittable tablecentertxt" id="all-coupon-table">
                <thead>
                    <tr>
                        <th scope="col" class="custom-width">ID</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="custom-name-width">Name</th>
                        <th scope="col">Code</th>
                        <th scope="col">#of Cycles</th>
                        <th scope="col">Class</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Modify</th>
                        <th scope="col" class="display-none"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="updateshipping" tabindex="-1" role="dialog" aria-labelledby="updateshipping" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close edit-model-close-btn" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                        <h1>Edit Coupons</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="edit-coupon-form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="" placeholder="">
                    <div class="row">
                        @include('coupon.partials._couponform', ['form' => ''])

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
                    <div class="topbx">
                        <h1>Add New Coupon</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="add-coupon-form"  method="post" enctype="multipart/form-data">
                    <div class="row">

                       @include('coupon.partials._couponform', ['form' => 'create'])

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">Create Coupon</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
    $(function(){
        function hideData() {
            $('.product_id').hide();
            $('.device_id').hide();
            $('.sim_id').hide();
            $('.addon_id').hide();
        }

        $('body').on('change', '.product_type', function(e) {
            $('.product_id_label').show();
            var table = $(this).val();
            if(table == 1) {
                hideData();
                $('.product_id').show();
            } else if(table == 2) {
                hideData();
                $('.device_id').show();
            } else if(table == 3) {
                hideData();
                $('.sim_id').show();
            } else if(table == 4) {
                hideData();
                $('.addon_id').show();
            }
        });
                
        let plan_to_addon = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: "{{ route('plans-to-addon') }}"
        });

        plan_to_addon.initialize();
        let plan_to_addon_input = $('.product_id_addon');
        plan_to_addon_input.tagsinput({
            itemValue: 'id',
            itemText: 'name',
            typeaheadjs: {
                name: 'plan_to_addon',
                displayKey: 'name',
                source: plan_to_addon.ttAdapter(),
            }
        });
            

        let device_to_addon = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: "{{ route('device-to-addon') }}"
        });

        device_to_addon.initialize();
        let device_to_addon_input = $('.device_to_addon');
        device_to_addon_input.tagsinput({
            itemValue: 'id',
            itemText: 'name',
            typeaheadjs: {
                name: 'device_to_addon',
                displayKey: 'name',
                source: device_to_addon.ttAdapter(),
            }
        });
            

        let sim_to_addon = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: "{{ route('sim-to-addon') }}"
        });

        sim_to_addon.initialize();
        let sim_to_addon_input = $('.sim_to_addon');
        sim_to_addon_input.tagsinput({
            itemValue: 'id',
            itemText: 'name',
            typeaheadjs: {
                name: 'sim_to_addon',
                displayKey: 'name',
                source: sim_to_addon.ttAdapter(),
            }
        });
    

        let addon_to_addon = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: "{{ route('addon-to-addon') }}"
        });
            
        addon_to_addon.initialize();
        let addon_to_addon_input = $('.addon_to_addon');
        addon_to_addon_input.tagsinput({
            itemValue: 'id',
            itemText: 'name',
            typeaheadjs: {
                name: 'addon_to_addon',
                displayKey: 'name',
                source: addon_to_addon.ttAdapter(),
            }
        });

        let multiline_restrict_plans_addon = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: "{{ route('multiline-to-addon') }}"
        });
        multiline_restrict_plans_addon.initialize();
        let multiline_restrict_plans_addon_input = $('.multiline_restrict_plans_addon');
        multiline_restrict_plans_addon_input.tagsinput({
            itemValue: 'id',
            itemText: 'name',
            typeaheadjs: {
                name: 'multiline_restrict_plans_addon',
                displayKey: 'name',
                source: multiline_restrict_plans_addon.ttAdapter(),
            }
        });

        $('.start_date').datetimepicker({
            format:'Y-m-d H:i:s',
            mask: true,
        });
        $('.end_date').datetimepicker({
           format:'Y-m-d H:i:s',
            mask: true, 
        });
        $('.class').on('change', function() {
            var responseId = $(this).val();
            if(responseId == 2) {
                $('.product_type').show();
                hideData();
                $('.product_id_label').hide();
                $('.productType1').show();
                $('.sub_type').show();
                $('.productType2').hide(); 
            }else if(responseId == 3) {
                $('.product_type').show();
                var product_type = $('#product_type').val();
                if(product_type == 1) {
                    hideData();
                    $('.product_id').show();
                    $('.product_id_label').show();
                } else if(product_type == 2) {
                    hideData();
                    $('.device_id').show();
                    $('.product_id_label').show();
                } else if(product_type == 3) {
                    hideData();
                    $('.sim_id').show();
                    $('.product_id_label').show();
                } else if(product_type == 4) {
                    hideData();
                    $('.addon_id').show();
                    $('.product_id_label').show();
                }
                $('.productType2').show();
                $('.productType1').hide();
                $('.sub_type').hide();
            } else {
                $('.sub_type').hide();
                $('.product_type').val('');
                $('.product_type').hide();
                $('.product_id_label').hide();
                $('.productType2').hide();
                $('.productType1').hide();  
                $('.product_id').hide();  
                $('.product_name').hide();           
            }
        });
        $('.type').on('change', function() {
            var responseId = $(this).val();
            if(responseId != '') {
                $('.sub_type').show();
            } else {
                $('.sub_type').show();
            }
        });
        !$('.num_cycles').val() ? $('.multiline_max').hide() && $('.multiline_min').hide() && $('.multiline_restrict_plans').hide() : null;

        $('#add-coupon-form').on('change', function () {
            let min = $(this).find('input[name="multiline_min"]').val(),
                max = $(this).find('input[name="multiline_max"]').val(),
                planRestriction = $(this).find('.multiline_restrict_plans'),
                restricted = min + max;
            restricted < 1 ? planRestriction.hide() : planRestriction.show();
        });

        $('#edit-coupon-form').on('change', function () {
            let min = $(this).find('input[name="multiline_min"]').val(),
                max = $(this).find('input[name="multiline_max"]').val(),
                planRestriction = $(this).find('.multiline_restrict_plans'),
                restricted = min + max;
            restricted < 1 ? planRestriction.hide() : planRestriction.show();
        });

        loadCouponData();
        function loadCouponData() {
            $('#all-coupon-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('allcoupon.datatable') }}",
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
                        "data": 'status',
                        'class' :'text-center',
                    },
                    { "data": 'name' },
                    { "data": 'code' },
                    { "data": 'cycles' },
                    { "data": 'class' },
                    { "data": 'amount' },
                    { "data": 'start-date' },
                    { "data": 'end-date' },
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
            let data = $(this).parents('tr').find('.data-row').text(),
                numCycles  = $('.num_cycles');
            setValue(data);

            triggerCheckbox(numCycles.val() == 0);
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

        $('body').on('submit', '#edit-coupon-form', function(e) {
            e.preventDefault();
            $form = $('#edit-coupon-form');
            validateForm($form);
            if ($form.valid()) {
                editCoupon();
            }
        });

        $('body').on('change', '.num_cycles', function() {
            multilineTrigger($(this));
        });

        function setValue(data) {
            data = JSON.parse(data);
            console.log(data);
            
            $('.product_type2').hide();
            $('.product_id_label').hide();
            hideData();
            const $form = $('#edit-coupon-form');
            $form.find('em').hide();
            if(data.num_cycles == 1) {
                $('.multiline_max').hide();
                $('.multiline_min').hide();
                $('.multiline_restrict_plans').hide();
            } else {
                $('.multiline_max').show();
                $('.multiline_min').show();
                $('.multiline_restrict_plans').show();
            }
            if(data.active == 0) {
                $('#active').prop('checked', false); 
            } else {
                $('#active').prop('checked', true);
            }

            $form.find('#class').val(data.class);
            $form.find('#name').val(data.name);
            $form.find('#id').val(data.id);
            $form.find('#fixed_or_perc').val(data.fixed_or_perc);
            $form.find('#code').val(data.code);
            $form.find('#amount').val(data.amount);
            $form.find('#num_cycles').val(data.num_cycles);
            $form.find('#num_uses').val(data.num_uses);
            $form.find('#max_uses').val(data.max_uses);
            $form.find('#stackable').val(data.stackable);
            $form.find('#start_date').val(data.start_date);
            $form.find('#end_date').val(data.end_date);
            $form.find('#multiline_min').val(data.multiline_min);
            $form.find('#multiline_max').val(data.multiline_max);
            $form.find('#multiline_restrict_plans').val(data.multiline_restrict_plans);
            $form.find('#type').val(data.coupon_product_types.type);
            data.coupon_products.forEach(function(element) {
                $('.productType2').show();
                $('.productType1').hide();
                $('.sub_type').hide();
                $form.find('#product_type').val(element.product_type);
            });
            data.coupon_product_types.forEach(function(element) {
                $('.productType1').show();
                $('.productType2').hide();
                $form.find('#type').val(element.type);
            });
            data.coupon_product_types.forEach(function(element) {
                $('.sub_type').show();
                $('.productType2').hide();
                $form.find('#sub_type').val(element.sub_type);
            })
            $form.find('#addon_id').tagsinput('removeAll');
            $form.find('#sim_id').tagsinput('removeAll');
            $form.find('#device_id').tagsinput('removeAll');
            $form.find('#product_id').tagsinput('removeAll');
            data.coupon_products.forEach(function(element) {
                if(element.length !== 0) {
                    $('.product_id_label').show();
                    var productType = $('#product_type').val();
                    if(productType == 1) {
                        hideData();
                        $('.product_id').show();
                        $form.find('#product_id').tagsinput('add', { id: element.product_id, name: element.product});
                    } else if(productType == 2) {
                        hideData();
                        $('.device_id').show();
                        $form.find('#device_id').tagsinput('add', { id: element.product_id, name: element.product});
                    } else if(productType == 3) {
                        hideData();
                        $('.sim_id').show();
                        $form.find('#sim_id').tagsinput('add', { id: element.product_id, name: element.product});
                    } else if(productType == 4) {
                        hideData();
                        $('.addon_id').show();
                        $form.find('#addon_id').tagsinput('add', { id: element.product_id, name: element.product});
                    }
                    $('.productType1').hide();
                    $('.sub_type').hide();
                }
            });
            $form.find('#num_uses').val('0');
            $form.find('#multiline_restrict_plans').tagsinput('removeAll');
            data.multiline_plan_types.forEach(function(element) {
                $form.find('#multiline_restrict_plans').tagsinput('add', { id: element.plan_type, name: element.name});
            });
        }

        function validateForm($form) {
            $form.validate({
                rules: {
                    num_cycles: {
                        required:     true,
                        number:       true 
                    },
                    max_uses: {
                        required:     true,
                        number:       true
                    },
                    num_uses: {
                        required:     true,
                        number:       true
                    },
                    type:           "required",
                    product_type:    "required", 
                    sub_type:               "required",
                    fixed_or_perc:          "required",
                    class:                  "required",
                    name:                   "required",
                    amount:                 "required",
                    code:{
                        required:  true,
                        remote :{
                            data: {id:  function () {
                                return $form.find('#id').val();
                                }
                            },
                            url: "{{ route('check.coupon') }}",
                            type: "post"
                        }
                    },
                    stackable:              "required",
                    // start_date:             "required",
                    // end_date:               "required",
                    // multiline_min:          "required",
                    // multiline_max:          "required",
                    product_id:           "required",
                    // multiline_restrict_plans: "required",
                },
                messages: {
                    num_cycles: {
                        required:      "Please enter number of cycles",
                        number:        "Number of cycles field can only have numeric value"
                    },
                    max_uses: {
                        required:      "Please enter maximum uses",
                        number:        "Maximum field can only have numeric value"
                    },
                    num_uses: {
                        required:      "Please enter number of uses",
                        number:        "Number of uses field can only have numeric value"
                    },
                    code: {
                        required:      "Please enter Coupon Code",
                        remote:        "Coupon code already in use"
                    },
                    class:                  "Please provide class", 
                    product_type:           "Please provide product type",
                    coupon_product_type:    "Please provide product type",
                    sub_type:               "Please provide sub type",
                    name:                   "Please provide name",
                    fixed_or_perc:          "Please provide fixed/percentage",
                    start_date:             "Please provide start date",
                    end_date:               "Please provide end date",
                    stackable:              "Please provide stackable",
                    multiline_max:          "Please provide Multiline Maximum",
                    multiline_min:          "Please provide Multiline Minimum",
                    product_name:           "Please provide product name",
                    multiline_restrict_plans: "Please provide Multiline Restrict Plans",
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

        function editCoupon() {
            let formData = $('#edit-coupon-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('edit.coupon') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    swal("Success!",'Coupon Sucessfully Edited!' , "success");
                    $('.edit-model-close-btn').click();
                    loadCouponData();   
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        function deleteProduct(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('delete.coupon') }}',
                dataType: 'json',
                data:{id: id },
                beforeSend: showLoader,
                success: function (data) {
                    if (data['error']) {
                        swal(data['error'])
                    } else {
                        swal("Success!",'Coupon Deleted Sucessfully!' , "success");
                        loadCouponData();
                    }

                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            })
        }

        $('body').on('submit', '#add-coupon-form', function(e) {
            e.preventDefault();
            $form = $('#add-coupon-form');
            $form.find('input').each(function(){
                this.value=$(this).val().trim();
            });
            validateForm($form);
            if ($form.valid()) {
                addCoupon();
            }
        });

        $('body').on('click', '.trigger', function(e) {
            triggerCheckbox($('.trigger-box').hasClass('square-unchecked'));
            multilineTrigger($('.num_cycles'));
        })

        function addCoupon() {
            let formData = $('#add-coupon-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('add.coupon') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    swal("Success!",'Coupon Successfully Added!' , "success");
                    $('.close').click();
                    loadCouponData();   
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }
        
        function triggerCheckbox(condition)
        {
            let triggerBox = $('.trigger-box'),
                numCycles  = $('.num_cycles');
            
            if (condition) {
                triggerBox.removeClass('square-unchecked');
                triggerBox.addClass('square-checked');
                numCycles.val(0);
                numCycles.hide();
            } else {
                numCycles.show();
                triggerBox.addClass('square-unchecked');
                triggerBox.removeClass('square-checked');
            }
        }

        function multilineTrigger(inputData)
        {
            var responseValue = inputData.val();
            if(responseValue == 1) {
                $('.multiline_max').hide();
                $('.multiline_min').hide();
                $('.multiline_max').find('input[name="multiline_max"]').val(null);
                $('.multiline_min').find('input[name="multiline_min"]').val(null);
                $('.multiline_restrict_plans').find('.label-info').html('');
                $('.multiline_restrict_plans').hide();
                $('.bootstrap-tagsinput').tagsinput('removeAll');
            } else {
                $('.multiline_max').show();
                $('.multiline_min').show();
                // $('.multiline_restrict_plans').show();
            }
        }
    });
</script>
@endpush 