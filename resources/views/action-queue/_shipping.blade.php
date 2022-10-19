@push('css')
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap2.css') !!}
@endpush
<div class="tab-pane active" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src='{{ asset("theme/img/icon_acti.png") }}' width="11" height="11" alt=""/></span>Shipping</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="tabletags">
                        <p>Tags :</p>
                        <button type="button" class="btn shipping-date-btn tag1" value = "1">Today</button>
                        <button type="button" class="btn shipping-date-btn tag2" value = "2">1 Day</button>
                        <button type="button" class="btn shipping-date-btn tag3" value = "3">2 Days</button>
                        <button type="button" class="btn shipping-date-btn tag4" value = "4">3 Days</button>
                        <button type="button" class="btn shipping-date-btn tag5" value = "5">4 Days</button>
                        <button type="button" class="btn shipping-date-btn tag6" value = "0">5+ Days</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable tablecentertxt" id="table">
                    <thead>
                    <tr>
                        <th scope="col" class = ""></th>
                        <th scope="col" class = "custom-name">Name</th>
                        <th scope="col" class = "sorting-width">Order Number</th>
                        <th scope="col" class = "extra-sorting-width">Porting No. /DAC (?)</th>
                        <th scope="col" class = "no-sort-option">Product</th>
                        <th scope="col" class = "no-sort-option">Shipping Address</th>
                        <th scope="col" class = "no-sort-option">Processed</th>
                        <th scope="col" class = "no-sort-option">Action</th>
                        <th class="display-none"></th>
                        <th class="display-none"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Update Shipping Popup Model modalsss -->
<div class="modal fade bd-example-modal-xl" id="updateshipping" tabindex="-1" role="dialog" aria-labelledby="updateshipping" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                        <h1>Update Shipping</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="shipping-form">
                    <input type="hidden" class="all-shipping-data" value="">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Order No.</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 shipping-order-id">
                            <p>Order No</p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Date of Order</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 shipping-date">
                            <p>Date</p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Product</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 shipping-product">
                            <p><strong>Product</strong></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Name</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 shipping-name">
                            <p>Name</p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Address</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 shipping-address">
                            <p>Address</p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Tracking No<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 shipping-tracking-no">
                            <input type="text" class="form-control effect-1" id ="tracking_num" name="tracking_num" placeholder="" value = "">
                            <span class="focus-border"></span>
                            <p class="invalid-tracking-num display-none error-msg">Please Enter Tracking Number</p>
                        </div>

                        <div class="form-group col-sm-12 col-md-6 sim-card-no">
                            <label>Sim Card No<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 sim-no sim-card-no">

                        </div>

                        <div class="form-group col-sm-12 col-md-6 imei">
                            <label>IMEI<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 imei">
                            <input type="text" class="form-control effect-1" id ="imei" name="imei" maxlength="15" placeholder="" value = "">
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="shipping_date">Shipping Date</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 shipping_date">
                            <input type="date" class="form-control effect-1" id ="shipping_date" name="shipping_date">
                            <span class="focus-border"></span>
                        </div>
                        {{-- <div class="form-group col-sm-12 col-md-6 shipping-sim-no">
                        <p></p>
                        </div> --}}
                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="button" class="btn lightbtn2 mark-final-shipped-btn" ><span class="fas fa-truck"></span>Mark Shipped</button>
                            <p class="mt-3"><span class="txtred">*</span>Warning: Submitting this form will manually override the normal shipping process wherein the tracking # and Sim card # are pulled from ReadyCloud.<br>
                                <br>
                                When Submitted, this record will be forwarded to the activation team.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js') !!}
    <script>
        $(function(){
            $(".shipping-tab-btn").on("click", loadSubcriptionData(0));

            $('.shipping-date-btn').on('click', function(e){
                e.preventDefault();
                loadSubcriptionData($(this).val());
            });

            $('#shipping_date').prop('max', function(){
                return new Date().toJSON().split('T')[0];
            });

            function loadSubcriptionData(date = 0) {
                $('#table').DataTable( {
                    "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                    "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "info": true,
                    "bDestroy": true,
                    "language": {
                        "processing": 'Please wait...',
                    },
                    "ajax": {
                        "url": "{{ URL::route('actionQueue.datatables') }}",
                        data: function ( d ) {
                            d.date = date;
                        },
                        beforeSend: showLoader,
                        complete: hideLoader,
                        error: function (xhr,status,error) {
                            if(xhr.status == '401'){
                                location.reload();
                            }
                        },
                    },
                    "columns": [
                        {
                            "data": 'first',
                            'class' :'date-icon',

                        },
                        { "data": 'name' },
                        { "data": 'order-number' },
                        { "data": 'porting-no' },
                        {
                            "class": "all-product",
                            "data" : 'product',
                            "orderable": false,
                        },
                        {
                            "data": 'shipping-address',
                            "orderable": false,

                        },
                        { "data": 'processed' },
                        {
                            "data": 'action',
                            "orderable": false,

                        },
                        {
                            "class": "display-none data-row",
                            "data" : 'all-data',
                            "orderable": false,
                        },
                        {
                            "class": "display-none data-id",
                            "data" : 'id',
                            "orderable": false,
                        }
                    ]
                });
            }

            $('body').on('click', '.markshippedbtn', shippingData);

            function shippingData() {
                let $this = $(this).parents('tr');
                $('.selected-tr').removeClass('selected-tr');
                $this.addClass('selected-tr');
                let dataText = $this.find('.data-row').text();
                data = JSON.parse(dataText);
                $('.form-group p').text();
                $('em').hide();
                $('.shipping-order-id p').text(data.order.order_num);
                $('.shipping-date p').text(data.created_at_formatted);
                $('.shipping-product p strong').html($this.find('.all-product').html());
                $('.shipping-name p').text(data.order.full_shipping_name);
                $('.shipping-address p').html(data.order.full_address);
                $('#tracking_num').val('');
                $('#tracking_num').val(data.tracking_num);
                $('.all-shipping-data').val(dataText);
                $imeiInput = $('#imei');
                $imeiInput.val(null);
                let maxLength = dynamicLength();
                if(data.plan_id){//Sub
                    $('.sim-card-no').removeClass('display-none');
                    $('.sim-no').html('<input type="text" class="form-control effect-1" id ="sim_num" name="sim_num" placeholder="" value = "'+data.sim_card_num+'" maxlength="'+maxLength+'"><span class="focus-border"></span>');
                    if(data.device_id && data.device_id != 0){//SWD
                        $imeiInput.val(data.device_imei);
                        $('.imei').removeClass('display-none');
                        $imeiInput.prop('disabled', false);
                    }else{
                        $imeiInput.prop('disabled', true);
                        $('.imei').addClass('display-none');
                    }
                }
                else if(data.sim_num){//SSS
                    $('.sim-card-no').removeClass('display-none');
                    $('.sim-no').html('<input type="text" class="form-control effect-1" id ="sim_num" name="sim_num" placeholder="" value = "'+data.sim_num+'" maxlength="'+maxLength+'"><span class="focus-border"></span>');
                    $('.imei').addClass('display-none');
                    $imeiInput.prop('disabled', true);
                }
                else if(data.device_id && data.device_id != 0){//SSD
                    $imeiInput.val(data.device_imei);
                    $('.imei').removeClass('display-none');
                    $imeiInput.prop('disabled', false);
                    $('.sim-card-no').addClass('display-none');
                }
                else{
                    $('.sim-card-no').addClass('display-none');
                    $('.imei').addClass('display-none');
                    $imeiInput.prop('disabled', true);
                }
            }

            $('.mark-final-shipped-btn').on('click', function(e){
                e.preventDefault();
                data = $('.all-shipping-data').val();
                data = JSON.parse(data);
                validateData();
                if ($('#shipping-form').valid()) {
                    AjaxMarkShipped(data);
                }
            });

            function AjaxMarkShipped(data) {
                var formData = {};
                if(data.plan_id){
                    formData = {
                        subscription_id: data.id,
                        tracking_num: $('#tracking_num').val(),
                        imei: $('#imei').val(),
                        sim_num: $('#sim_num').val(),
                    };
                }else if(data.device_id){
                    formData = {
                        customer_standalone_device_id: data.id,
                        imei: $('#imei').val(),
                        tracking_num: $('#tracking_num').val()
                    };
                }else if(data.sim_id){
                    formData = {
                        customer_standalone_sim_id: data.id,
                        tracking_num: $('#tracking_num').val(),
                        sim_num: $('#sim_num').val(),
                    };
                }
                if($('#shipping_date').val() !== ''){
                    formData.shipping_date = $('#shipping_date').val();
                }
                $.ajax({
                    type: 'POST',
                    url: '{{ route('mark.shipped') }}',
                    dataType: 'json',
                    data: formData,
                    beforeSend: showLoader,
                    success: function (data) {
                        $('.selected-tr').addClass('display-none');
                        $('.dataTables_info').addClass('display-none');
                        $('.close').click();
                        $('.close').click();
                    },
                    complete: hideLoader,
                    error: function (xhr,status,error) {
                        firstXhrError(xhr);
                    }
                });
            };

            function dynamicLength()
            {
                if (data['plans']) {
                    if (data['plans']['carrier_id'] == '1' || data['plans']['carrier_id'] == '5') {
                        return 19;
                    } else {
                        return 20;
                    }
                } else if (data['sim']) {
                    if (data['sim']['carrier_id'] == '1' || data['sim']['carrier_id'] == '5') {
                        return 19;
                    } else {
                        return 20;
                    }

                } else if (data['device']) {
                    if (data['device']['carrier_id'] == '1' || data['device']['carrier_id'] == '5') {
                        return 19;
                    } else {
                        return 20;
                    }

                }
            }

            function validateData() {
                $('#shipping-form').validate({
                    rules: {
                        sim_num: {
                            required:  true,
                            number:    true,
                            maxlength: dynamicLength,
                            minlength: dynamicLength,
                        },
                        imei:{
                            required:  true,
                            number:    true,
                            maxlength: 15,
                            minlength: 15,
                        },
                        tracking_num:{
                            required:  true
                        }

                    },
                    messages: {
                        sim_num:{
                            required:          "Please provide Sim Number.",
                        },
                        tracking_num:{
                            required:          "Please Enter Tracking Number"
                        },
                        imei:{
                            required:  "Please Enter IMEI Number",
                            number:    "IMEI can only be numeric",
                            maxlength: "IMEI must be of 15 digits",
                            minlength: "IMEI must be of 15 digits",
                        },
                    },

                    errorElement: "em",

                    errorPlacement: function( error, element ){
                        error.addClass('form-text text-muted text-danger');
                        error.insertAfter(element);
                    },
                    success: function( label, element ){
                    },
                });
            }

            $('body').on('click', '#processed', function () {
                let $this = $(this);
                let processed = $this.val();
                if(processed == '1'){
                    processed = '0';
                }else{
                    processed = '1';
                }
                $this.attr('value', processed);

                let data = $this.parents('tr').find('.data-row').text();
                data = JSON.parse(data);

                let formData = null;
                if(data.plan_id){
                    formData = {
                        subscription_id: data.id,
                        processed: processed
                    };
                }else if(data.device_id){
                    formData = {
                        customer_standalone_device_id: data.id,
                        processed: processed
                    };
                }else if(data.sim_id){
                    formData = {
                        customer_standalone_sim_id: data.id,
                        processed: processed
                    };
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('update.processed') }}',
                    dataType: 'json',
                    data: formData,
                    beforeSend: showLoader,
                    success: function (data) {
                    },
                    complete: hideLoader,
                    error: function (xhr,status,error) {
                        firstXhrError(xhr);
                    }
                });
            });
        });

    </script>
@endpush