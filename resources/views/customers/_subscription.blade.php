<div class="tab-pane fade show active" id="subscriptions" role="tabpanel" aria-labelledby="subscriptions-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1>
                        <span>
                            <img src="{{ asset('theme/img/active_img.png') }}" width="11" height="11" alt=""/>
                        </span>Active / Pending Lines
                    </h1>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table" id="subscription-table">
                    <thead>
                    <tr>
                        <th scope="col" class = "no-sort-option custom-width">Active Number</th>
                        <th scope="col" class = "no-sort-option">BAN</th>
                        <th scope="col" class = "no-sort-option">Label</th>
                        <th scope="col" class = "no-sort-option">SIM Number</th>
                        <th scope="col" class = "no-sort-option">Plan</th>
                        <th scope="col" class = "no-sort-option custom-width">Features</th>
                        <th scope="col" class = "no-sort-option">Port-In Number</th>
                        <th scope="col" class = "no-sort-option subscription-activation">Activation Date</th>
                        <th scope="col" class = "no-sort-option custom-width">Status</th>
                        <th scope="col" class = "no-sort-option active-action">Action </th>
                        <th class = "no-sort-option display-none"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="pattseprator"></div>
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src="{{ asset('theme/img/closed_img.png') }}" width="11" height="11" alt=""/></span>Closed Lines</h1>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table" id ="subscription-close-table">
                    <thead>
                    <tr>
                        <th scope="col" class="no-sort-option custom-width">Active Number</th>
                        <th scope="col" class="no-sort-option">BAN</th>
                        <th scope="col" class="no-sort-option">Label</th>
                        <th scope="col" class="no-sort-option">SIM Number</th>
                        <th scope="col" class="no-sort-option">Plan</th>
                        <th scope="col" class="no-sort-option custom-width">Features</th>
                        <th scope="col" class="no-sort-option">Port-In Number</th>
                        <th scope="col" class="no-sort-option">Activation Date</th>
                        <th scope="col" class="no-sort-option">Status</th>
                        <th scope="col" class="no-sort-option">Action </th>
                        <th scope="col" class="no-sort-option"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="portpopup" tabindex="-1" role="dialog" aria-labelledby="portpopup" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx">
                        <h1>Send Port Request</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="port-info" class="port-info">
                    <input type="hidden" class="port-id" id="id" name ="id" readonly>
                    <input type="hidden" id="subscription_id" name ="subscription_id" readonly>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="authorized_name">Authorized Name<span class="text-danger"> *</span></label>
                            <input type="text" id="authorized_name" name ="authorized_name" class="form-control effect-1" placeholder="Please Enter Authorized Name">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="address_line1">Address Line 1<span class="text-danger"> *</span></label>
                            <input type="text" id="address_line1" name="address_line1" class="form-control effect-1" placeholder="Address Line 1">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="address_line2">Address Line 2</label>
                            <input type="text" id ="address_line2" name="address_line2" class="form-control effect-1" placeholder="Address Line 2">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="city">City<span class="text-danger"> *</span></label>
                            <input type="text" id="city" name="city" class="form-control effect-1" placeholder="Please Enter City">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="state">State<span class="text-danger"> *</span></label><br>
                            {!! Form::select('state', $states, null, ['class' => 'width-100', 'id'=>'state']) !!}
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="zip">Zip Code<span class="text-danger"> *</span></label>
                            <input type="text" id="zip" name="zip" class="form-control effect-1" placeholder="Zip">
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="ssn_taxid">SSN/Tax ID(Optional)</label>
                            <input type="text" id="ssn_taxid" name="ssn_taxid" class="form-control effect-1" placeholder="SSN/Tax ID(Optional)">
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="sim_card_number">SIM Card Number<span class="text-danger"> *</span></label>
                            <input type="text" id="sim_card_number" name="sim_card_number" class="form-control effect-1" placeholder="SIM Card Number" disabled>
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="number_to_port">Number to Port<span class="text-danger"> *</span></label>
                            <input type="text" id ="number_to_port" name ="number_to_port" class="form-control effect-1" placeholder="Number to Port" maxlength="10">
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="company_porting_from">Phone Company you are porting from<span class="text-danger"> *</span></label>
                            <input type="text" id="company_porting_from" name="company_porting_from" class="form-control effect-1" placeholder="">
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="account_number_porting_from">Account Number of former carrier<span class="text-danger"> *</span></label>
                            <input type="text" id="account_number_porting_from" name="account_number_porting_from" class="form-control effect-1" placeholder="">
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="account_pin_porting_from">Account Pin of former carrier<span class="text-danger"> *</span></label>
                            <input type="text" id="account_pin_porting_from" name="account_pin_porting_from" class="form-control effect-1" placeholder="">
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-12 mt-4 text-right">
                            <button type="submit" class="btn lightbtn final-port-submit-btn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Marked as Completed Popup Model modalsss -->
<div class="modal fade bd-example-modal-xl" id="unsuspendConfirmation" tabindex="-1" role="dialog" aria-labelledby="unsuspendConfirmation" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx topbx-2">
                        <h1>Warning!</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <p>Only reopen if within closed billing cycle. Otherwise confirm with admin before reopening to ensure that billing works properly.</p>
                <button type="button" class="btn lightbtn2 reopen-btn" data-dismiss="modal" aria-label="Confirm" data-subscription-id=""><span class="fas fa-check"></span>Confirm</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="order-replacement-product-modal" tabindex="-1" role="dialog" aria-labelledby="order-replacement-product-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close edit-model-close-btn" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                        <h1>Order Replacement Product</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="order-replacement-product-form" method="post">
                    <input type="hidden" name="sim_id" id="replacement_sim_id" value="">
                    <input type="hidden" name="device_id" id="replacement_device_id" value="">
                    <input type="hidden" name="subscription_id" id="replacement_subscription_id" value="">
                    <input type="hidden" name="customer_id" id="replacement_customer_id" value="{{ $customer->id }}">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-4">
                            <label for="replacement-product-internal-notes">Internal Notes<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-12 col-md-8">
                            <textarea name="internal_notes" id="replacement-product-internal-notes" class="form-control effect-1"></textarea>
                        </div>

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">Order</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script type="text/javascript">
        $(function(){
            $('.subscription-tab-btn').on('click', function () {
                loadData();
                loadSubscriptionCloseData();
            });

            portFormValidate();

            function format ( data ) {

                let portButton ='';
                if(data.port == null ||data.port.status !='3'){
                    portButton = '<button type="button" class="btn btn1 mt-1 port-btn" data-toggle="modal" data-target="#portpopup">Port</button>';
                }else{
                    portButton = '<button type="button" class="btn btn1 mt-1">NA</button>';
                }

                let subscriptionBlock ='';
                if(data.subscription_block[0] == null){
                    subscriptionBlock ='NA';
                }
                data.subscription_block.forEach(function(element) {
                    if(element.is_on){
                        subscriptionBlock +='<div class="row">'+
                            '<div class="col-sm-12 col-md-9">'+
                            '<p>'+element.carrier_block.display_name+'</p>'+
                            '</div>'+
                            '<div class="col-sm-12 col-md-3">'+
                            '<label class="switch">'+
                            '<input type="checkbox" id="is_on'+element.id+'" name="is_on[]" value = "'+element.id+'" checked> <span class="slider round"></span>'+
                            '</label>'+
                            '</div>'+
                            '</div>';
                    }else{
                        subscriptionBlock +='<div class="row">'+
                            '<div class="col-sm-12 col-md-9">'+
                            '<p>'+element.carrier_block.display_name+'</p>'+
                            '</div>'+
                            '<div class="col-sm-12 col-md-3">'+
                            '<label class="switch">'+
                            '<input type="checkbox" id="is_on'+element.id+'" name="is_on[]" value = "'+element.id+'"> <span class="slider round"></span>'+
                            '</label>'+
                            '</div>'+
                            '</div>';
                    }
                });

                let coupon = '',
                    deviceImei = '',
                    ban = '',
                    banGroup = '',
                    phoneType = '';

                deviceImei = '<div class="form-group col-sm-12 col-md-4">'+
                    '<label for="device_imei">Device IMEI<span class="text-danger"> *</span></label><i class="fa fa-edit ml-2 cursor-pointer toggle-device-imei"></i>'+
                    '<input type="text" id="device_imei" name="device_imei" class="form-control effect-1" aria-describedby="emailHelp" value="'+data.device_imei+'" placeholder="IMEI" maxlength="20" data-mask="000-000-000-000-000" autocomplete="off" disabled> <span class="focus-border"></span>'+
                    '</div>';
                phoneType = '<div class="form-group col-sm-12 col-md-4">'+
                    '<label for="exampleInputEmail1">Device Type:</label>'+
                    '{{ Form::select('device_os', ['' => '']+ $deviceOs, null, ['id' => 'device_os', 'class' => 'custom-select effect-1']) }}'+
                    '</div>'

                if (data.slug == 'at&amp;t') {
                    ban = '{{ Form::select('ban_id', ['' => '']+ $atBan->toArray(), null, ['id' => 'ban_id', 'class' => 'custom-select effect-1']) }}';
                    banGroup =  '<div class="form-group col-sm-12 col-md-4">'+
                        '<div class="row">'+
                        '<div class="col-sm-12 col-md-12">'+
                        '<label class="select-box-label" for="ban-group-number">Group</label>'+
                        '</div>'+
                        '<div class="col-sm-12 col-md-12 bangroup">'+
                        '</div>'+
                        '</div>'+
                        '<span class="focus-border"></span>'+
                        '</div>';
                }
                else if(data.slug == "t-mobile"){
                    ban = '{{ Form::select('ban_id', ['' => '']+ $tmobBan->toArray(), null, ['id' => 'ban_id', 'class' => 'custom-select effect-1']) }}';
                }
                else{
                    ban = '{{ Form::select('ban_id', ['' => '']+ $allBan->toArray(), null, ['id' => 'ban_id', 'class' => 'custom-select effect-1']) }}';
                }
                data.subscription_coupon.forEach(function(element) {
                    if (coupon) {
                        coupon +='<li><span class="fas fa-check "></span>'+element.coupon.code
                            +'</li>'
                    }
                });
                return '<tr id="morebutton" class="collapse show" style="">'+
                    '<td colspan="11" class="morebuttonopen">'+
                    '<div class="tbcdataout">'+
                    '<div class="table-responsive">'+
                    '<div class="tbcdata">'+
                    '<div class="row">'+
                    '<div class="col-sm-12 col-md-12 col-lg-6 bdr-right">'+
                    '<div class="tbdata mt-5" style="padding: 0;">'+
                    '<div class="row">'+

                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-sm-12 col-md-12 col-lg-6 bdr-right">'+
                    '<button type="button" class="close close-more-btn float-right"> <span aria-hidden="true">×</span> </button>'+
                    '<form id="editsubcription">'+
                    '<div class="row">'+
                    '<div class="col-sm-12 col-md-12 col-lg-12">'+
                    '</div>'+
                    '<div class="col-sm-12 col-md-12 col-lg-12 txthdrn">'+
                    '<h1>Line Data</h1>'+
                    '<button style="background: transparent" class="border-none float-right" type="submit" ><a style="background: none !important" class="roundborderdbtn"><span class="fas fa-save"></span>Save Changes</a></<button>'+
                    '</div>'+
                    '</div>'+
                    '<div class="row">'+
                    '<div class="col-sm-12 col-md-12 col-lg-12">'+
                    '<input type ="hidden" id="subcription_id" name ="subcription_id" value="' + data.id + '" readonly>'+
                    '<div class="moreforms">'+
                    '<div class="row">'+
                    '<div class="form-group col-sm-12 col-md-4">'+
                    '<label for="phone_number">Active Number<span class="text-danger"> *</span></label><i class="fa fa-edit ml-2 cursor-pointer toggle-active-number"></i>'+
                    '<input type="text" id="phone_number" name="phone_number" value="'+data.phone_number+'" class="form-control effect-1" aria-describedby="emailHelp" placeholder="Active Number" maxlength="10" data-mask="000-000-0000" autocomplete="off" disabled> <span class="focus-border"></span>'+
                    '</div>'+
                    '<div class="form-group col-sm-12 col-md-4">'+
                    '<label for="sim_card_num">Sim Number<span class="text-danger"> *</span></label><i class="fa fa-edit ml-2 cursor-pointer toggle-sim-number"></i>'+
                    '<input type="text" name="sim_card_num" id="sim_card_num" class="form-control effect-1" aria-describedby="emailHelp" value="'+data.sim_card_num+'" placeholder="Sim Number" maxlength="24" data-mask="000-000-000-000-000-0000" autocomplete="off" disabled> <span class="focus-border"></span>'+
                    '</div>'+
                    deviceImei+
                    '<div class="form-group col-sm-12 col-md-4">'+
                    '<div class="row">'+
                    '<div class="col-sm-12">'+
                    '<label class="select-box-label" for="ban-account">BAN:</label>'+
                    '</div>'+
                    '<div class="col-sm-12 col-md-12">'+
                    ban+
                    '<input type="hidden" class="current_ban_group" value='+data.ban_group_id+'>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    banGroup+
                    '<div class="form-group col-sm-12 col-md-4">'+
                    '<label for="sim_name">Sim Type<span class="text-danger"> *</span></label><i class="fa fa-edit ml-2 cursor-pointer toggle-sim-type"></i>'+
                    data.sim+
                    '</div>'+
                    phoneType+
                    '<div class="form-group col-sm-12 col-md-4">'+
                    '<label for="order_num">Order Number :</label>'+
                    '<input type="text" id="order_num" name="order_num" class="form-control effect-1" aria-describedby="emailHelp" value="'+data.order.order_num+'" placeholder="Order Number" disabled> <span class="focus-border"></span>'+
                    '</div>'+
                    '<div class="form-group col-sm-12 col-md-4">'+
                    '<label for="tracking_num">Tracking Number<span class="text-danger"> *</span></label><i class="fa fa-edit ml-2 cursor-pointer toggle-tracking-number"></i>'+
                    '<input type="text" id="tracking_num" name="tracking_num" class="form-control effect-1" aria-describedby="emailHelp" value="'+data.tracking_num+'" placeholder="Tracking Number" disabled> <span class="focus-border"></span>'+
                    '</div>'+
                    '<div class="form-group col-sm-12 col-md-4">'+
                    '<label for="label">Label</label>'+
                    '<input type="text" id="label" name="label" class="form-control effect-1" aria-describedby="emailHelp" value="'+data.label+'" placeholder="Label"> <span class="focus-border"></span>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '<div class="row">'+
                    '<div class="col-sm-12 col-md-12 col-lg-6 txthdrn">'+
                    '<h1>Blocks</h1>'+
                    '<div class="blocksbxs">'
                    +subscriptionBlock+
                    '</div>'+
                    '</div>'+
                    '<div class="col-sm-12 col-md-12 col-lg-6 txthdrn">'+
                    '<h1>Actions</h1>'+
                    '<div class="btns float-left m-0 w-100">'+portButton+
                    '</div>'+
                    '</div>'+
                    '<div class="col-sm-12 col-md-12 col-lg-12 txthdrn mt-4">'+
                    '<h1>Used Coupons</h1>'+
                    '<ul class="serviceslist" id="coupon-display-'+data.id+'">'
                    +coupon+
                    '</ul>'+
                    '</div>'+
                    '</div>'+
                    '</form>'+
                    '<div style="width: 320px;">'+
                    '<label style="float: left;" for="coupon-'+data.id+'">Coupon</label><br>'+
                    '<input style="float: left;" type="text" id="coupon-'+data.id+'" name="coupon" class="form-control effect-1" placeholder="Enter coupon code">'+
                    '<button style="float: right; margin-top: 3px;" type="button" class="btns add-coupon-button" data-subscription_id="'+data.id+'" id="apply-coupon">Add</button>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</td>'+
                    '</tr>';
            }

            function loadSubscriptionCloseData() {

                let dt = $('#subscription-close-table').DataTable({
                    "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                    "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "info": true,
                    "bDestroy": true,
                    "ajax": {
                        "url": "{{ URL::route('customer.subscription.datatables', $customer->id) }}",
                        beforeSend: showLoader,
                        complete: hideLoader,
                        "data": function ( d ) {
                            d.isClose = true;
                        }
                    },
                    "language": {
                        "processing": "Please Wait...",
                    },
                    "columns": [

                        { "data": 'phone-no' },
                        { "data": 'ban' },
                        { "data": 'label' },
                        { "data": 'sim-num' },
                        { "data": 'plans' },
                        { "data": 'add-ons' },
                        { "data": 'port-number' },
                        { "data": 'activation-date' },
                        { "data": 'status' },
                        {
                            "class": "more-btn",
                            "data" : 'action'
                        },
                        {
                            "class": "display-none data-row",
                            "data" : 'all-data'
                        },
                    ]
                });

                let detailRows = [];

                $('#subscription-close-table tbody').on( 'click', '.edit-subscription-button', function () {
                    let tr = $(this).closest('tr');
                    let row = dt.row( tr );
                    let idx = $.inArray( tr.attr('id'), detailRows );
                    tr.addClass( 'details' );
                    row.child( format( row.data() ) ).show();
                    $form = tr.next('tr').find("form");
                    $form.find('#ban_id').val(row.data().ban_id);
                    $form.find('#ban_id').selectize({
                        create: false,
                        sortField: 'text'
                    });
                    $form.find('#ban_id').val(row.data().ban_id);
                    getBanNunber(row.data().ban_id, row.data().ban_group_id, $form);
                    // alert(row.data().device_os);
                    $form.find('#device_os').val(row.data().device_os);
                    $form.find('#sim_name').val(row.data().sim_name);
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                } );

                $('#subscription-close-table tbody').on( 'click', '.close-more-btn', function () {
                    $(this).parents('tr').hide();
                });
            }

            function loadData() {
                let dt = $('#subscription-table').DataTable({
                    "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                    "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "info": true,
                    "order": [[ 7, "desc" ]],
                    "bDestroy": true,
                    "ajax": {
                        "url": "{{ URL::route('customer.subscription.datatables', $customer->id) }}",
                        beforeSend: showLoader,
                        complete: hideLoader, "data": function ( d ) {
                            d.isClose = false;
                        }

                    },
                    "language": {
                        "processing": "Please Wait...",
                    },
                    "columns": [

                        {
                            "class": "image-phoneno",
                            "data" : 'phone-no'
                        },
                        { "data": 'ban' },
                        { "data": 'label' },
                        { "data": 'sim-num' },
                        { "data": 'plans' },
                        { "data": 'add-ons' },
                        { "data": 'port-number' },
                        { "data": 'activation-date' },
                        {
                            "data": "status",
                            "class" : 'customer-billing-status'
                        },
                        {
                            "class": "more-btn",
                            "data" : 'action'
                        },
                        {
                            "class": "display-none data-row",
                            "data" : 'all-data'
                        },
                    ]
                });

                let detailRows = [];

                $('#subscription-table tbody').on( 'click', 'tr td.more-btn', function () {
                    let tr = $(this).closest('tr');
                    let row = dt.row( tr );
                    let idx = $.inArray( tr.attr('id'), detailRows );
                    tr.addClass( 'details' );
                    row.child( format( row.data() ) ).show();
                    $form = tr.next('tr').find("form");
                    $form.find('#ban_id').val(row.data().ban_id);
                    $form.find('#ban_id').selectize({
                        create: false,
                        sortField: 'text'
                    });
                    $form.find('#ban_id').val(row.data().ban_id);
                    getBanNunber(row.data().ban_id, row.data().ban_group_id, $form);
                    // alert(row.data().device_os);
                    $form.find('#device_os').val(row.data().device_os);
                    $form.find('#sim_name').val(row.data().sim_name);
                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                } );

                $('#subscription-table tbody').on( 'click', '.close-more-btn', function () {
                    $(this).parents('tr').hide();
                });

            }

            $('body').on( 'change', '#ban_id', function () {
                $form = $(this).closest("form");
                getBanNunber($(this).val(), $(this).next('.current_ban_group').val(), $form);
            });

            function getBanNunber(id, currentBan, $form){
                const formData = {id: id};
                if(id){
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('ban.group') }}',
                        dataType: 'json',
                        data:formData,
                        success: function (data) {
                            let $select = '<select class="custom-select effect-1" id="ban_group_id" name="ban_group_id">'+
                                '<option></option>';
                            $.each(data, function(key, value) {
                                if(key == currentBan){
                                    $select += '<option selected value =' + key +  '>' + value +  '</option>'
                                }else{
                                    $select += '<option value =' + key +  '>' + value +  '</option>'
                                }
                            });
                            $select += '</select>';
                            $form.find(".bangroup").html($select);
                            $form.find('#ban_group_id').selectize({
                                create: false,
                                sortField: 'text'
                            });
                        },
                        error: function (xhr,status,error) {
                            firstXhrError(xhr);
                        }
                    });
                }
            }

            $('body').on( 'submit', '#editsubcription', function (e) {
                e.preventDefault();
                let $form = $(this).closest("form");
                validateEditSubcription($form);
                if ($form.valid()) {
                    editSubcription($form);
                }
            });

            function editSubcription($form) {
                // const editform = $("#editsubcription");
                const formData = $form.serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('update.subcription') }}',
                    dataType: 'json',
                    data:formData,
                    beforeSend: showLoader,
                    success: function (data) {
                        swal("Success!",'Subscription Updated!' , "success");
                        loadData();
                        loadSubscriptionCloseData();
                    },
                    complete: hideLoader,
                    error: function (xhr,status,error) {
                        firstXhrError(xhr);
                    }
                });
            }

            $('body').on('click', '.port-btn', function(f) {
                let allData = JSON.parse($(this).parents('tr').prev('tr').find('.data-row').text());
                if(allData.port){
                    data = allData.port;
                    $('#id').val(data.id);
                    $('#authorized_name').val(data.authorized_name);
                    $('#address_line1').val(data.address_line1);
                    $('#address_line2').val(data.address_line2);
                    $('#city').val(data.city);
                    $('#zip').val(data.zip);
                    $('#state').val(data.state);
                    $('#ssn_taxid').val(data.ssn_taxid);
                    $('#number_to_port').val(data.number_to_port);
                    $('#company_porting_from').val(data.company_porting_from);
                    $('#account_number_porting_from').val(data.account_number_porting_from);
                    $('#status').val(data.status);
                    $('#account_pin_porting_from').val(data.account_pin_porting_from);
                    $('#sim_card_number').val(allData.sim_card_num);
                }else{
                    $('#port-info input').val('');
                    $('#subscription_id').val(allData.id);
                    $('#sim_card_number').val(allData.sim_card_num);
                    $('#state').val(null);
                }

            });

            function applyCoupon(customerId, subscriptionId, coupon)
            {
                if (coupon) {
                    $.ajax({
                        url: '{{ route('apply.coupon') }}',
                        method: 'post',
                        data: {
                            code: coupon,
                            customer_id: customerId,
                            subscription_id: subscriptionId
                        },
                        success: function(response) {
                            getCoupons(subscriptionId);
                            if (response['error']) {
                                swal({
                                    title: 'Oops!',
                                    icon: 'error',
                                    text: response['error']
                                })
                            } else if (response['success']) {
                                swal({
                                    title: 'Coupon added',
                                    icon: 'success',
                                    text: response['success']
                                });
                            }
                        }
                    });
                } else {
                    swal('Please select a coupon code');
                }
            }

            function getCoupons(subscriptionId)
            {
                let couponSection = $('#coupon-display-'+subscriptionId);
                $.ajax({
                    url: '{{ route('get.coupon') }}',
                    method: 'post',
                    data: {
                        subscription_id: subscriptionId
                    },
                    error: function(res) {
                        swal('Server error');
                    },
                    success: function(res) {
                        if (res) {
                            couponSection.html('');
                            let customerCoupons = res['customer_coupons'] ? res['customer_coupons'] : [],
                                subscriptionCoupons = res['subscription_coupons'] ? res['subscription_coupons'] : [];
                            showCoupons(subscriptionCoupons.concat(customerCoupons), couponSection, subscriptionId);
                        }
                    }
                });
            }

            function showCoupons(coupons, couponSection, subscriptionId)
            {
                if (coupons) {
                    for (let i = 0; i < coupons.length; i++) {
                        let coupon = coupons[i];
                        if (coupon) {
                            let cycles = coupon['cycles_remaining'] == -1 ? 'Infinite' : coupon['cycles_remaining'];
                            couponSection.append(
                                '<li style="display: ruby-base;" class="coupon-code" data-sub_id="'+subscriptionId+'" data-id="'+coupon['id']+'" data-cycles="'+cycles+'" title="">'+
                                '<i class="fa fa-check"></i>'+coupon['code']+
                                '</li>'
                            );
                        }
                    }
                } else {
                    couponSection.html('<small>No coupons used</small>');
                }
            }

            $('body').on('click', '#apply-coupon', function(f) {
                let customerId = $(this).attr('data-customer_id'),
                    subscriptionId = $(this).attr('data-subscription_id'),
                    coupon  = $('#coupon-'+subscriptionId).val();
                applyCoupon(customerId, subscriptionId, coupon);
            });

            $('body').on('submit', '#port-info', function(f) {
                f.preventDefault();
                portFormValidate(f);
                if ($('.port-info').valid()) {
                    updatePortAjax();
                }
            });

            $('body').on('click', '.morebtn', function(f) {
                let subscriptionId = $(this).attr('data-subscription_id');
                getCoupons(subscriptionId);
            });

            $('body').on('mouseenter', '.coupon-code', function () {
                let container = $(this),
                    numCycles = container.attr('data-cycles'),
                    id      = container.attr('data-id'),
                    subscriptionId = container.attr('data-sub_id'),
                    button    = container.find('svg');
                container.attr('title', 'Remaining cycles: '+numCycles);
                // button.html('<button><i style="cursor: pointer" class="delete-coupon fa fa-trash" data-id="'+id+'" data-sub_id="'+subscriptionId+'" aria-hidden="true"></i></button>');
            });

            $('body').on('mouseleave', '.coupon-code', function () {
                let container = $(this),
                    button    = container.find('svg');
                button.html('<i class="fa fa-check"></i>');
            });

            function updatePortAjax() {
                const formData = $('#port-info').serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('update.port') }}',
                    dataType: 'json',
                    data:formData,
                    beforeSend: showLoader,
                    success: function (data) {
                        swal("Success!",'Port Request Submited' , "success");
                        loadData();
                        loadSubscriptionCloseData();
                        $('#portpopup .close').click();
                    },
                    complete: hideLoader,
                    error: function (xhr,status,error) {
                        firstXhrError(xhr);
                    }
                });
            };

            function portFormValidate() {
                $('.port-info').validate({
                    rules: {
                        authorized_name: {
                            required:  true,
                            maxlength:  20,
                        },
                        zip: {
                            required:   true,
                            minlength:  5,
                            maxlength:  5,
                            number:     true
                        },
                        address_line1: {
                            required:   true,
                        },
                        city: {
                            required:   true,
                            maxlength:  25,
                        },
                        state: {
                            required:   true,
                        },
                        number_to_port: {
                            required:   true,
                            minlength:  10,
                            maxlength:  10,
                            number:     true,
                            remote :{
                                url: "{{ route('check.number') }}",
                                type: "post"
                            }
                        },
                        company_porting_from: {
                            required:   true,
                        },
                        account_number_porting_from: {
                            required:   true,
                            digits:     true
                        },
                        account_pin_porting_from: {
                            required:   true,
                            digits:     true
                        },
                    },
                    messages: {
                        authorized_name:{
                            required:          "Please provide Authorized Name.",
                            maxlength:          "Authorized name can't be so long"
                        },
                        zip:{
                            required:          "Please provide Pin",
                            minlength:         "Zip must be of 5 digit",
                            maxlength:         "Zip must be of 5 digit",
                        },
                        address_line1:          "Please provide Address.",
                        city:{
                            required:          "Please provide city.",
                            maxlength:         "City name can't be so long"
                        },
                        state:                  "Please provide state Name.",
                        number_to_port:{
                            required:          "Please provide Number to port.",
                            number:            "Must be numeric number",
                            minlength:         "Number must be of 10 digit",
                            maxlength:         "Number must be of 10 digit",
                            remote:            "Number already Active",
                        },
                        company_porting_from:    "Please provide company Name.",
                        account_pin_porting_from:    {
                            required:        "Please provide company Name.",
                            digits:          "Account Pin should contain only digits"
                        },
                        account_number_porting_from:    {
                            required:        "Please provide Authorized Name.",
                            digits:          "Account Number should contain only digits"
                        }
                    },

                    errorElement: "em",

                    errorPlacement: function( error, element ){
                        $(element).addClass('is-invalid');
                        error.addClass('form-text text-muted text-danger');
                        error.insertAfter(element);
                    },
                    success: function( label, element ){
                        $(element).removeClass("is-invalid");
                    },
                });
            };

            function validateEditSubcription($form) {
                $form.validate({
                    rules: {
                        phone_number: {
                            required:  true,
                            minlength: 10,
                            maxlength: 10,
                            number:    true,
                            remote: {
                                data: {
                                    id:  function () {
                                        return $form.find('#subcription_id').val();
                                    }
                                },
                                url: "{{ route('check.number') }}",
                                type: "post"
                            }
                        },
                        sim_card_num: {
                            required:  true,
                            number:    true,
                            minlength: 10,
                            maxlength: 20,
                        },
                        device_imei: {
                            required:   true,
                            minlength: 10,
                            maxlength: 20,
                        },
                        sim_name: {
                            required:   true,
                        },
                        tracking_num: {
                            required:   true,
                        },
                        ban_id: {
                            required:   true,
                        },
                    },
                    messages: {
                        phone_number:{
                            remote : 'Phone Number already exist'
                        }
                    },

                    errorElement: "em",

                    errorPlacement: function( error, element ){
                        $(element).addClass('is-invalid');
                        error.addClass('form-text text-muted text-danger');
                        error.insertAfter(element);
                    },
                    success: function( label, element ){
                        $(element).removeClass("is-invalid");
                    },
                });
            }

            $('body').on('click', '.reopen-btn', ajaxUpdateReopen)

            function ajaxUpdateReopen() {
                var formData = {
                    id: $(this).attr('data-subscription-id')
                };
                $.ajax({
                    type: 'POST',
                    url: '{{ route('reopen.closed') }}',
                    dataType: 'json',
                    data: formData,
                    beforeSend: showLoader,
                    success: function (data)
                    {
                        if(data.hasOwnProperty('status') && data.status === 'error' && data.hasOwnProperty('message')) {
                            swal("Error!", data.message, "error");
                        } else {
                            loadSubscriptionCloseData();
                            swal("Success!", data.message, "success");
                        }
                    },
                    complete: hideLoader,
                    error: function (xhr, status, error) {
                        firstXhrError(xhr);
                    }
                });
            }


            $('body').on('click', '.first-reopen-btn', function(){
                var subscriptionRow = $(this).parents('tr').find('.data-row').text();
                var subscriptionId = JSON.parse(subscriptionRow).id;
                $('.reopen-btn').attr('data-subscription-id', subscriptionId);
            });
        });


        $('body').on('click', '.close-subscription', function(e) {
            e.preventDefault();
            $this = $(this).parents('td');
            let $confirmBtn = $this.find('.confirm-active-btn');
            if($(this).text() == "Close"){
                $confirmBtn.val('close');
            }else{
                $confirmBtn.val('suspended');
            }
            $this.find('.active-action-btn').addClass('display-none');
            $this.find('.action-confirm-btn').removeClass('display-none');
            let today = new Date();
            let maxDate = new Date($this.find('.billind-cycles').attr('data-date'));
            maxDate.setDate(maxDate.getDate()+1);

            $this.find('.date').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'mm/dd/yyyy',
                startDate: today,
                endDate: maxDate,
            }).datepicker('update', today);
        });

        $('body').on('click', '.action-confirm-close-btn', function(e) {
            e.preventDefault();
            $this = $(this).parents('td');
            $this.find('.active-action-btn').removeClass('display-none');
            $this.find('.action-confirm-btn').addClass('display-none')
        });

        $('body').on('click', '.confirm-active-btn', ajaxUpdateActive)

        function ajaxUpdateActive() {
            $this = $(this).parents('tr');
            let allData= JSON.parse($this.find('.data-row').text());

            formData = {
                id: allData.id,
                date: $this.find('.active-date').val(),
                type:$(this).val()
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('mark.active') }}',
                dataType: 'json',
                data: formData,
                beforeSend: showLoader,
                success: function (data) {
                    if(data.hide){
                        $this.addClass('display-none');
                    }
                },
                complete: hideLoader,
                error: function (xhr, status, error) {
                    firstXhrError(xhr);
                }
            });
        }

        $('body').on('click', '.toggle-active-number', function(e){
            e.preventDefault();
            var inputElement = $('#phone_number');
            if(inputElement.prop('disabled')){
                inputElement.prop('disabled', false);
                inputElement.focus();
            } else {
                inputElement.prop('disabled', true);
            }
        });

        $('body').on('click', '.toggle-sim-number', function(e){
            e.preventDefault();
            var inputElement = $('#sim_card_num');
            if(inputElement.prop('disabled')){
                inputElement.prop('disabled', false);
                inputElement.focus();
            } else {
                inputElement.prop('disabled', true);
            }
        });

        $('body').on('click', '.toggle-device-imei', function(e){
            e.preventDefault();
            var inputElement = $('#device_imei');
            if(inputElement.prop('disabled')){
                inputElement.prop('disabled', false);
                inputElement.focus();
            } else {
                inputElement.prop('disabled', true);
            }
        });

        $('body').on('click', '.toggle-sim-type', function(e){
            e.preventDefault();
            var inputElement = $('.subscription_sim_name');
            if(inputElement.prop('disabled')){
                inputElement.prop('disabled', false);
                inputElement.focus();
            } else {
                inputElement.prop('disabled', true);
            }
        });

        $('body').on('click', '.toggle-tracking-number', function(e){
            e.preventDefault();
            var inputElement = $('#tracking_num');
            if(inputElement.prop('disabled')){
                inputElement.prop('disabled', false);
                inputElement.focus();
            } else {
                inputElement.prop('disabled', true);
            }
        });


        $('body').on('click', '.subscription-replace-sim-card', function(e){
            e.preventDefault();
            $("#order-replacement-product-modal").modal('show');
            $("#order-replacement-product-modal #replacement_device_id").val('');
            $("#order-replacement-product-modal #replacement_subscription_id").val($(this).attr('data-subscription-id'));
            $("#order-replacement-product-modal #replacement_sim_id").val($(this).attr('data-sim-id'));
        });

        $('body').on('click', '.subscription-replace-device', function(e){
            e.preventDefault();
            $("#order-replacement-product-modal").modal('show');
            $("#order-replacement-product-modal #replacement_sim_id").val('');
            $("#order-replacement-product-modal #replacement_subscription_id").val($(this).attr('data-subscription-id'));
            $("#order-replacement-product-modal #replacement_device_id").val($(this).attr('data-device-id'));
        });

        $('body').on('click', '.subscription-replace-sim-device', function(e){
            e.preventDefault();
            $("#order-replacement-product-modal").modal('show');
            $("#order-replacement-product-modal #replacement_subscription_id").val($(this).attr('data-subscription-id'));
            $("#order-replacement-product-modal #replacement_sim_id").val($(this).attr('data-sim-id'));
            $("#order-replacement-product-modal #replacement_device_id").val($(this).attr('data-device-id'));
        });

        $('#order-replacement-product-form').validate({
            rules: {
                internal_notes: {
                    required:     true
                }
            },
            messages: {
                internal_notes: {
                    required:      "Please enter internal notes"
                }
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

        $('body').on('submit', '#order-replacement-product-form', function(e) {
            e.preventDefault();
            var form = $('#order-replacement-product-form');
            var formWithoutEmptyData = $("#order-replacement-product-form :input[value!='']");
            if (form.valid()) {
                orderReplacementProduct(formWithoutEmptyData);
            }
        });

        function orderReplacementProduct(formWithoutEmptyData) {
            var formData = formWithoutEmptyData.serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('order-replacement-product') }}',
                dataType: 'json',
                data: formData,
                beforeSend: showLoader,
                success: function (data) {
                    hideLoader();
                    swal("Success!",'Replacement product successfully ordered!' , "success");
                    $('.close').click();
                },
                complete: hideLoader,
                error: function (xhr, status, error) {
                    hideLoader();
                    firstXhrError(xhr);
                }
            });
        }


    </script>
@endpush
