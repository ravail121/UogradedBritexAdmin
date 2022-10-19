<div class="tab-pane" id="updowngrade" role="tabpanel" aria-labelledby="updowngrade-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src='{{ asset("theme/img/active_img.png") }}' width="11" height="11" alt=""/></span>Upgrade/Downgrade</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="tabletags">
                        <p>Tags :</p>
                        <button type="button" class="btn upgrade-date-btn tag1" value = "1">Today</button>
                        <button type="button" class="btn upgrade-date-btn tag2" value = "2">1 Day</button>
                        <button type="button" class="btn upgrade-date-btn tag3" value = "3">2 Days</button>
                        <button type="button" class="btn upgrade-date-btn tag4" value = "4">3 Days</button>
                        <button type="button" class="btn upgrade-date-btn tag5" value = "5">4 Days</button>
                        <button type="button" class="btn upgrade-date-btn tag6" value = "0">5+ Days</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="subscribersdata planstable">
            <div class="table-responsive">
                <table class="table audittable tablecentertxt mainbigtable" id="upgrade-table">
                    <thead>
                        <tr>
                            <th scope="col" class = ""></th>
                            <th scope="col" class = "custom-name">Name</th>
                            <th scope="col" class = "">Phone No.</th>
                            <th scope="col" class = "no-sort-option">Upgrade/Downgrade</th>
                            <th scope="col" class = "">Due Date </th>
                            <th scope="col" class = "no-sort-option">Plan (Old)</th>
                            <th scope="col" class = "">Order No</th>
                            <th scope="col" class = "no-sort-option">Plan (New)</th>
                            <th scope="col" class = "no-sort-option">Action</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src='{{ asset("theme/img/active_img.png") }}' width="11" height="11" alt=""/></span>Add-Ons</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    {{-- <div class="tabletags">
                        <p>Tags :</p>
                        <button type="button" class="btn addon-date-btn tag1" value = "1">Today</button>
                        <button type="button" class="btn addon-date-btn tag2" value = "2">1 Day</button>
                        <button type="button" class="btn addon-date-btn tag3" value = "3">2 Days</button>
                        <button type="button" class="btn addon-date-btn tag4" value = "4">3 Days</button>
                        <button type="button" class="btn addon-date-btn tag5" value = "5">4 Days</button>
                        <button type="button" class="btn addon-date-btn tag6" value = "0">5+ Days</button>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="subscribersdata planstable">
            <div class="table-responsive">
                <table class="table audittable tablecentertxt mainbigtable" id="addon-table">
                    <thead>
                        <tr>
                            <th scope="col" class = ""></th>
                            <th scope="col" class = "custom-name">Name</th>
                            <th scope="col" class = "">Phone No.</th>
                            <th scope="col" class = "no-sort-option">Add/Remove</th>
                            <th scope="col" class = "">Due Date </th>
                            <th scope="col" class = "">Order No</th>
                            <th scope="col" class = "no-sort-option">Add-Ons</th>
                            <th scope="col" class = "no-sort-option">Action</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="modal fade bd-example-modal-xl" id="updatecompleteaddon" tabindex="-1" role="dialog" aria-labelledby="updatecompleteaddon" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content editpopcontent">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="topbx purplebg" style="margin:0 0 40px 0;">
                                <h1>Complete Addons Adding/Removal</h1>
                            </div>
                        </div>
                    </div>
                    <div class="popvtmcont">
                        <form>
                            <input type="hidden" class="all-addon-data" value = "">
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Name </label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 addon-dataname">
                                    <p>Name</p>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Phone No</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 addon-dataphone">
                                    <p>Number</p>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Add/Remove</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 addon-datastatus">
                                    <p><strong></strong></p>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Due Date</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 addon-dataduedate">
                                    <p>Due Date</p>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Order No.</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 addon-dataorderno">
                                    <p>OrderNo</p>
                                    <span class="focus-border"></span> </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Plan Name</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 addon-dataplanname">
                                    <p>Plan</p>
                                    <span class="focus-border"></span> </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Ban Account</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 databan">
                                    {{ Form::select('ban', ['' => '']+ $allBan, null, ['id' => 'upgrade-addon-ban-account', 'class' => 'form-control effect-1']) }}
                                        <p class ="invalid-ban-upgrade error-msg display-none">Please select valid Ban Account</p>
                                    <span class="focus-border"></span>
                                </div>
                                <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                                    <button type="button" class="btn mark-complete-addon-btn lightbtn2" data-dismiss="modal"><span class="fas fa-truck"></span>Mark Complete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-xl" id="updatecomplete" tabindex="-1" role="dialog" aria-labelledby="updatecomplete" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content editpopcontent">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="topbx purplebg" style="margin:0 0 40px 0;">
                                <h1>Complete Upgrade/Downgrade</h1>
                            </div>
                        </div>
                    </div>
                    <div class="popvtmcont">
                        <form id="upgrade-plan">
                            <input type="hidden" class="all-data-model" value = "">
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Name </label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 dataname">
                                    <p>Nane</p>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Phone No</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 dataphone">
                                    <p>Number</p>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Upgrade/Downgrade</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 datastatus">
                                    <p><strong>Upgrade</strong></p>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Due Date</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 dataduedate">
                                    <p>Due Date</p>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Plan (Old)</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 dataoldplan">
                                    <p>Old Plan</p>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Plan (New)</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 datanewplan">
                                    <p>New plan</p>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Order No.</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 dataorderno">
                                    <p>OrderNo</p>
                                    <span class="focus-border"></span> </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Ban Account</label>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 databan-plan">
                                    <span>BAN SELECT BOX</span>
                                    <p class ="invalid-ban-upgrade error-msg display-none">Please select valid Ban Account</p>
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
                                    <button type="button" class="btn mark-complete-btn lightbtn2" data-dismiss="modal"><span class="fas fa-truck"></span>Mark Complete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(function(){
        $(".upgrade").on("click", function() {
            loadData();
            loadAddonData();
        });

        $(".upgrade-date-btn").on("click", function() {
            loadData($(this).val());
        });

        $(".addon-date-btn").on("click", function() {
            loadAddonData($(this).val());
        });

        function loadData(date = 0) {
            $('#upgrade-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('actionQueue.upgrade.datatables') }}",
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
                    "processing": 'Please Wait...',
                },
                "columns": [
                    {   
                        "data": 'first',

                    },
                    { "data": 'name' },
                    { "data": 'phone-no' },
                    {   
                        "data": 'upgrade-downgrade',
                        "orderable": false,

                    },
                    { "data": 'due-date' },
                    {   
                        "data": 'old-plan',
                        "orderable": false,

                    },
                    { "data": 'new-order' },
                    {   
                        "data": 'new-plan',
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
                ]
                
            });
        }

        function loadAddonData(date = 0) {
            $('#addon-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('actionQueue.addon.datatables') }}",
                    beforeSend: showLoader,
                    complete: hideLoader,
                    "data": function ( d ) {
                            d.date = date;
                        }
                },
                "language": {
                    "processing": 'Please Wait...',
                },
                "columns": [
                    {   
                        "data": 'first',

                    },
                    { "data": 'name' },
                    { "data": 'phone-no' },
                    {   
                        "data": 'add-remove',
                        "orderable": false,

                    },
                    {   
                        "data": 'due-date',
                        "class": 'addon-due-date',

                    },
                    {   
                        "data": 'order-num',
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
                ]
                
            });
        }
        $('body').on('click', '.completedbtn', selectData);

        $('body').on('click', '.completed-addon-btn', selectAddonData);

        function selectAddonData() {
            let $this = $(this).parents('tr');
            $('.selected-tr').removeClass('selected-tr');
            $this.addClass('selected-tr');
            let dataText = $this.find('.data-row').text();
            data = JSON.parse(dataText);
            $('.addon-dataname p').text(data.subscription.customer.full_name);
            $('.addon-dataphone p').text(data.subscription.phone_number_formatted);
            $('.addon-datastatus p strong').text(data.status);
            $('.addon-dataorderno p').text(data.subscription.order.order_num);
            $('.addon-dataplanname p').text(data.subscription.plans.name);
            $('.addon-dataduedate p').html($this.find('.addon-due-date').text());
            $('.all-addon-data').val(dataText);
            $(".databan .item").remove();
            $selectAddon[0].selectize.clear();
            if(data.subscription.ban != null){
                $('.databan input').before('<div class="item default-upgrade-ban" data-value='+data.subscription.ban.id+'>'+data.subscription.ban.number+'</div>');
                $('.databan').on('click', function() {
                    $('.default-upgrade-ban').remove();
                })
            }
        }

        function selectData() {
            let $this = $(this).parents('tr');
            $('.selected-tr').removeClass('selected-tr');
            $this.addClass('selected-tr');
            let dataText = $this.find('.data-row').text();
            data = JSON.parse(dataText);
            $('.dataname p').text(data.customer.full_name);
            $('.dataphone p').text(data.phone_number_formatted);
            $('.datastatus p strong').text(data.upgrade_downgrade_status);
            if(data.old_plan){
                $('.dataoldplan p').text(data.old_plan.name);
            }else{
                $('.dataoldplan p').text("No Old plan Found");
            }
            if(data.plans){
                $('.datanewplan p').text(data.plans.name);
            }else{
                $('.datanewplan p').text("No New plan Found");
            }
            $('.dataorderno p').text(data.order.order_num);
            $('.all-data-model').val(dataText);
            $('.bangroup').addClass('display-none');
            $('#upgrade-plan #selectbangroup').val(null)

            $selectBox = getBanSelectBox(data);
            $(".databan-plan span").html($selectBox);
            $banSelectBox = $('.databan-plan .ban-data');
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

            if(data.upgrade_downgrade_status == "for-upgrade"){
                $('.dataduedate p').text(data.upgrade_date_formatted);    
            }else{
                $('.dataduedate p').text(data.downgrade_date_formatted);
            }
        }

        $('#upgrade-ban-account').on('change',function() {
            let id = $('#upgrade-ban-account').val();
            if(id == ""){
                $('.invalid-ban-upgrade').removeClass('display-none');
                $('.bangroup').addClass('display-none');
                $(".activation-bangroup p").html('<p></p>');
            }else{
                $('.invalid-ban-upgrade').addClass('display-none');
            }
        });

        $('.mark-complete-btn').on('click', function(e){
            e.preventDefault();
            data = $('.all-data-model').val();
            data = JSON.parse(data);
            $('.selected-tr').addClass('display-none');
            $('.dataTables_info').addClass('display-none');
            AjaxUpdateComplete(data);
        });

        $('.mark-complete-addon-btn').on('click', function(e){
            e.preventDefault();
            data = $('.all-addon-data').val();
            data = JSON.parse(data);
            $('.selected-tr').addClass('display-none');
            $('.dataTables_info').addClass('display-none');
            AjaxUpdateAddonComplete(data);
        });

        function AjaxUpdateComplete(data) {
            const formData = {id: data.id,
                ban_id: $('.databan-plan .item').attr('data-value'),
                ban_group_id: $('#upgrade-plan #selectbangroup').val(),
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('update.complete') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        };

        function AjaxUpdateAddonComplete(data) {
            const formData = {id: data.id,
                ban_id: $('.databan .item').attr('data-value'),
                status: data.status,
                subscription_id: data.subscription_id
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('update.addon.complete') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        };
        
        let $selectPlan = $('.databan-plan .ban-data').selectize({
            create: false,
            sortField: 'text'
        });
        let $selectAddon = $('#upgrade-addon-ban-account').selectize({
            create: false,
            sortField: 'text'
        });
    });

    
</script>
@endpush