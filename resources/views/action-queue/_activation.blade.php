<div class="tab-pane" id="activation" role="tabpanel" aria-labelledby="activation-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <h1><span><img src="{{ asset("theme/img/icon_acti.png") }}" width="11" height="11" alt="Activation"/></span>Activation</h1>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="tabletags">
                        <button type="button" class="btn past-due-date-btn tag1" data-toggle="modal" data-target="#bulkActivationModal">
                            <i class="fa fa-plus"></i> Bulk Activate
                        </button>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 text-right">
                    <div class="tabletags">
                        <div class="tabletags">
                        <p>Tags :</p>
                        <button type="button" class="btn activation-date-btn tag1" value = "1">Today</button>
                        <button type="button" class="btn activation-date-btn tag2" value = "2">1 Day</button>
                        <button type="button" class="btn activation-date-btn tag3" value = "3">2 Days</button>
                        <button type="button" class="btn activation-date-btn tag4" value = "4">3 Days</button>
                        <button type="button" class="btn activation-date-btn tag5" value = "5">4 Days</button>
                        <button type="button" class="btn activation-date-btn tag6" value = "0">5+ Days</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <span id='all_ban_data' data-row="{{$ban}}"></span>
            <div class="table-responsive">
                <table class="table audittable tablecentertxt" id="activation-table">
                    <thead>
                        <tr>
                            <th scope="col" class=""></th>
                            <th scope="col" class="custom-name">Name</th>
                            <th scope="col" class="sorting-width">Order Number</th>
                            <th scope="col" class="extra-sorting-width">Porting No. /DAC (?)</th>
                            <th scope="col" class="sorting-width">IMEI</th>
                            <th scope="col" class="sorting-width">Sim Number</th>
                            <th scope="col" class="extra-sorting-width">Tracking Number</th>
                            <th scope="col" class="">Plan Type</th>
                            <th scope="col" class="no-sort-option">Add-Ons</th>
                            <th scope="col" class="">Action</th>
                            <th class="display-none"></th>
                            <th class="display-none"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Activateline Popup Model modalsss -->
<div class="modal fade bd-example-modal-xl" id="activateline" tabindex="-1" role="dialog" aria-labelledby="activateline" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                        <h1>Activate Line</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="activation-form" class ="">
                    <input type="hidden" class="all-data-model" value = "">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Order No.</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 activation-orderno">
                            <p></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Date of Order</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 activation-date">
                            <p>DATE</p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Plan</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 activation-plan">
                            <p><strong></strong></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Add-Ons</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 activation-addons">
                            <p class="txtred"></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Address</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 activation-address">
                            <p></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Tracking No.</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 activation-trackingno">
                            <p></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Device IMEI</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 activation-device_imei">
                            <p></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Sim Card No.</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 activation-simno">
                            <p></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Desire Area Code</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 activation-area-code">
                            <p>(N/A if user will be porting)</p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Phone No.</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 activation-phoneno">
                            <input type="text" id ="phone_number" name= "phone_number" class="form-control effect-1" placeholder="" value="">
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Ban Account</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 activation-banaccount">
                            <span>BAN SELECT BOX</span>
                            <p class ="invalid-ban error-msg display-none">Please select valid Ban Account</p>
                        </div>

                        <div class="form-group col-sm-12 col-md-6 bangroup display-none">
                            <label>Ban Group</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 bangroup activation-bangroup display-none">
                            <p></p>
                            <h5 class ="invalid-ban-group error-msg display-none">Please select valid Ban Account</h5>
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="final-activation-btn check-phone-no btn lightbtn2"><span class="fas fa-power-off"></span>Activate</button>
                            <p class="mt-3"><span class="txtred">*</span>Activating this record will change the status from "Activation" to "Completed".</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Bulk Activateline Popup Model modalsss -->
<div class="modal fade bd-example-modal-xl" id="bulkActivationModal" tabindex="-1" role="dialog" aria-labelledby="bulkActivationModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                        <h1>Bulk Activate Lines</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="bulk-activation-form" type="multipart/form-data">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="bulk_csv">CSV</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <input type="file" id ="bulk_csv" name= "bulk_csv" class="form-control effect-1">
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <p class="mt-3"> <a href="{{ asset("csv/bulk_activation.csv") }}" title="Download the sample CSV" target="_blank">Download the sample CSV</a></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="final-activation-btn check-phone-no btn lightbtn2"><span class="fas fa-power-off"></span>Bulk Activate </button>
                            <p class="mt-3"><span class="txtred">*</span>Activating records will change the status from "Activation" to "Completed".</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Marked as Completed Popup Model modalsss -->
<div class="modal fade bd-example-modal-xl" id="removeRequestedZip" tabindex="-1" role="dialog" aria-labelledby="removeRequestedZip" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx topbx-2">
                        <h1>Remove the requested ZIP?</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id="remove-requested-zip-form">
                    <input type="hidden" name="subscription_id" class="remove-requested-zip-subscription-id">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                <input type="checkbox" class="send-email-for-removed-zip-checkbox" name="send_email" id="send-email-for-removed-zip-checkbox" value="1" checked>
                            </div>
                            <div class="col-sm-6 col-md-8 checkbox-label">
                                <label for="send-email-for-removed-zip-checkbox">Send Email to the Customer<span class="text-danger"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-md-12 text-center mt-10">
                        <button type="submit" class="btn lightbtn2 remove-requested-zip-btn" aria-label="Confirm"><span class="fas fa-check"></span>Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    $(function(){
        $(".activation-tab-btn").on("click", function() {
            loadActivationData();
        });

         $('.activation-date-btn').on('click', function(e){
            e.preventDefault();
            loadActivationData($(this).val());
        });

        function loadActivationData(date = 0) {
            $('.close').click();
            $('#activation-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{ URL::route('actionQueue.activation.datatables') }}",
                    "data": function ( d ) {
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
                "language": {
                    "processing": "Please Wait...",
                },
                "columns": [
                    { 
                        "data": 'first',
                        'class' :'date-icon',
                    },
                    { "data": 'name'},
                    { "data": 'order-number' },
                    { "data": 'porting-no' },
                    { "data": 'device_imei' },
                    { "data": 'sim-num' },
                    { "data": 'tracking-no' },
                    { 
                        "data": 'plan-type',
                        "orderable": false,
                    },
                    {   
                        "data": 'add-ons',
                        "orderable": false,
                    },
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

        $('body').on('click', '.activation-btn', selectActivationData);

        function selectActivationData() {
            let $this = $(this).parents('tr');
            $('.selected-tr').removeClass('selected-tr');
            $this.addClass('selected-tr');
            let dataText = $this.find('.data-row').text();
            data = JSON.parse(dataText);
            $('.activation-orderno p').text(data.order.order_num);
            $('.activation-date p').text(data.order.date_processed_formatted);
            $('.activation-plan p').html($this.find('.plan-type').html());
            $('.activation-addons p').html($this.find('.add-ons').html());
            $('.activation-address p').html(data.order.full_address);
            $('.activation-trackingno p').text(data.tracking_num_formatted);
            $('.activation-device_imei p').text(data.device_imei);
            $('.activation-simno p').text(data.sim_card_num);
            $('.activation-area-code p').text(data.requested_area_code);
            $('.all-data-model').val(dataText);
            $('.activation-phoneno input').val(data.phone_number);

            $('.invalid-phone').addClass('display-none');
            $('.bangroup').addClass('display-none');
            $('.invalid-ban-group').addClass('display-none');
            $('.invalid-ban').addClass('display-none');

            $selectBox = getBanSelectBox(data);
            $(".activation-banaccount span").html($selectBox);
            $banSelectBox = $('.activation-banaccount .ban-data');
            if(data.ban != null){
                $banSelectBox.val(data.ban_id);
            }

            var $banSelectBox = $banSelectBox.selectize({
                create: false,
                sortField: 'text'
            });

            if(data.plans.carrier.slug == "at&t" )
                getBanNunber(data.plans.carrier.slug, data.ban_id, data.ban_group_id );

                $banSelectBox.on('change', function() {
                    getBanNunber(data.plans.carrier.slug, $('#ban-account').val(), null );
            });
        }

        $('body').on('submit', '#activation-form', function(e) {
            e.preventDefault();
            var data = $('.all-data-model').val();
            data = JSON.parse(data);
            validateActivationForm(data);

            if ($("#activation-form").valid()) {
                if ($('#ban-account').val()) {
                    $('.invalid-ban').addClass('display-none');
                    if (data.plans.carrier_id != 0 && data.plans.carrier.slug == "at&t") {
                        if ($('#selectbangroup').val()) {
                            $('.invalid-ban-group').addClass('display-none');
                            AjaxActivation(data);
                        } else {
                            $('.invalid-ban-group').removeClass('display-none');
                        }
                    } else {
                        AjaxActivation(data);
                    }
                } else {
                    if(data.plans.carrier_id === 13) {
                        $('.invalid-ban').addClass('display-none');
                        $('.invalid-ban-group').addClass('display-none');
                        AjaxActivation(data);
                    } else {
                        $('.invalid-ban').removeClass('display-none');
                    }

                }
            }
        });

        function AjaxActivation(data) {
            const formData = {
                id: data.id,
                phone_number: $('.activation-phoneno input').val(),
                ban_id: $('#ban-account').val(),
                ban_group_id: $('#selectbangroup').val(),
                carrier_id: data.plans.carrier_id
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('subscription.activation') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $('.selected-tr').addClass('display-none');
                    $('.dataTables_info').addClass('display-none');
                    $('#activateline').modal('hide');
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }
    });

    function validateActivationForm(argument) {
        $("#activation-form").validate({
            ignore: 'input[type=hidden], #ban-account-selectized',
            rules: {
                phone_number: {
                    required: function(element) {
                        return argument.plans.carrier_id !== 13
                    },
                    minlength: 12,
                    remote: {
                        url: "{{ route('subscription.check-phone-uniqueness') }}",
                        type: "post",
                        data: {
                            phone_number: function() {
                                return $('.activation-phoneno input').val();
                            },
                            id: function() {
                                return argument.id
                            }
                        }
                    }
                }
            },
            messages: {
                phone_number:{
                    required:    "Please provide Phone Number.",
                    number:      "Phone Number can only have numeric value",
                    minlength:   "Phone Number must be of 10 digits",
                    maxlength:   "Phone Number can't be more then 10 digits",
                    remote:      "The phone number is already taken"
                }
            }
        });
    }

    function getBanNunber(slug, id, activebangroup){
        if(slug == "at&t"){
            if(!id){
                $('.invalid-ban').removeClass('display-none');
                $('.bangroup').addClass('display-none');
                $(".activation-bangroup p").html('<p></p>');
            }else{
                $('.invalid-ban').addClass('display-none');
                const formData = {id: id};
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ban.group') }}',
                    dataType: 'json',
                    data:formData,
                    success: function (data) {
                        var $select = '<select autofocus id = selectbangroup class ="select-ban-group">';
                        $select += '<option></option>'
                        $.each(data, function(key, value) {
                            $select += '<option value =' + key +  '>' + value +  '</option>'
                        });

                        $select += '</select>';

                        $('.bangroup').removeClass('display-none');
                        $(".activation-bangroup p").html($select);
                        $banGroup = $('.select-ban-group');
                        $banGroup.val(activebangroup);
                        $banGroup.selectize({
                            create: false,
                            sortField: 'text'
                        });
                    },
                    error: function (data) {
                        $('.bangroup').addClass('display-none');
                        $(".activation-bangroup p").html('<p></p>');
                        firstXhrError(xhr);
                    }
                });
            }
        }
    }

    function getBanSelectBox(data) {
        let $selectBox = '<select autofocus id = ban-account class ="ban-data">';
        $selectBox += '<option></option>'
        $.each(JSON.parse($('#all_ban_data').attr('data-row')), function(key, value){
            if(data.plans.carrier_id == value.carrier_id){
                $selectBox += '<option value =' + value.id +  '>' + value.number +  '</option>'
            }
        });
        $selectBox += '</select>';
        
        return $selectBox;
    }

    $('body').on('submit', '#bulk-activation-form', function(e) {
        e.preventDefault();
        var form = $(this);
        validateBulkActivation(form);

        if (form.valid()) {
            AjaxBulkActivation(form);
        }
    });

    function validateBulkActivation(form) {
        form.validate({
            rules: {
                bulk_csv: {
                    required:     true,
                    extension: 'csv'
                },
            },
            messages: {
                bulk_csv: {
                    required:      "Please upload the CSV file",
                    extension:     "The uploaded file must be a CSV file"
                }
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

    function AjaxBulkActivation(form)
    {
        var formData = new FormData(form[0]);
        $.ajax({
            type: 'POST',
            url: "{{ route('subscription.bulk-activation') }}",
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: showLoader,
            success: function (data) {
                // $('.close').click();
                if(data.hasOwnProperty('status') && data.status === 'success' && data.hasOwnProperty('messages')){
                    form[0].reset();
                    form.find('.invalid-feedback').remove();
                    form.find('.is-invalid').removeClass('is-invalid');
                    var message = data.messages.join(', ');
                    swal("Success!", message, "success");
                }
                if(data.hasOwnProperty('status') && data.status === 'error' && data.hasOwnProperty('message')){
                    form[0].reset();
                    swal("Error!", data.message, "error");
                }

                if(data.hasOwnProperty('status') && data.status === 'error' && data.hasOwnProperty('messages')){
                    form[0].reset();
                    form.find('.invalid-feedback').remove();
                    form.find('.is-invalid').removeClass('is-invalid');
                    var message = data.messages.join(', ');
                    swal("Error!", message, "error");
                }
            },
            complete: hideLoader,
            error: function (xhr, status, error) {
                firstXhrError(xhr);
            }
        });
    }

    $('body').on('click', '.remove-requested-zip-button', function(e) {
        e.preventDefault();
        var subscriptionId = $(this).attr('data-subscription-id');
        $('#removeRequestedZip .remove-requested-zip-subscription-id').val(subscriptionId);
    });

    $('body').on('submit', '#remove-requested-zip-form', function(e) {
        e.preventDefault();
        var form = $(this);
        removeRequestedZipForm(form);
    });

    function removeRequestedZipForm(form){
        var formData = new FormData(form[0]);
        $.ajax({
            type: 'POST',
            url: "{{ route('subscription.remove-requested-zip') }}",
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: showLoader,
            success: function (data) {
                if(data.hasOwnProperty('status') && data.status === 'success' && data.hasOwnProperty('message')){
                    form[0].reset();
                    form.find('.invalid-feedback').remove();
                    form.find('.is-invalid').removeClass('is-invalid');
                    swal("Success!", data.message, "success");
                }
                if(data.hasOwnProperty('status') && data.status === 'error' && data.hasOwnProperty('message')){
                    form[0].reset();
                    swal("Error!", data.message, "error");
                }
                $('#removeRequestedZip').modal('hide');
            },
            complete: hideLoader,
            error: function (xhr, status, error) {
                firstXhrError(xhr);
            }
        });
    }
</script>
@endpush