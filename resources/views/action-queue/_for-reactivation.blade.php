<div class="tab-pane" id="reactivation" role="tabpanel" aria-labelledby="reactivation-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src='{{ asset("theme/img/icon_acti.png") }}' width="11" height="11" alt=""/></span>For-Reactivation</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="tabletags">
                        <p>Tags :</p>
                        <button type="button" class="btn for-reactivation-date-btn tag1" value="1">Today</button>
                        <button type="button" class="btn for-reactivation-date-btn tag2" value="2">1 Day</button>
                        <button type="button" class="btn for-reactivation-date-btn tag3" value="3">2 Days</button>
                        <button type="button" class="btn for-reactivation-date-btn tag4" value="4">3 Days</button>
                        <button type="button" class="btn for-reactivation-date-btn tag5" value="5">4 Days</button>
                        <button type="button" class="btn for-reactivation-date-btn tag6" value="0">5+ Days</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable tablecentertxt" id="for-reactivation-table">
                    <thead>
                        <tr>
                            <th scope="col" class=""></th>
                            <th scope="col" class="custom-name">Name</th>
                            <th scope="col" class="">Phone Number</th>
                            <th scope="col" class="">SIM Number</th>
                            <th scope="col" class="no-sort-option">Plan</th>
                            <th scope="col" class="custom-width no-sort-option">Add-Ons</th>
                            <th scope="col" class="no-sort-option">Action</th>
                            <th class="display-none"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Marked as Completed Popup Model modalsss -->
<div class="modal fade bd-example-modal-xl" id="markcomplete" tabindex="-1" role="dialog" aria-labelledby="markcomplete" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx green" style="margin:0 0 40px 0;">
                        <h1>You just mark this as completed!</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form>
                    <input type="hidden" class="reactivation-id">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Name</label>
                        </div>
                        <div class="reactivation-name form-group col-sm-12 col-md-6">
                            <p></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Phone No.</label>
                        </div>
                        <div class="reactivation-phoneno form-group col-sm-12 col-md-6">
                            <p></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Sim Card No.</label>
                        </div>
                        <div class="reactivation-simcardno form-group col-sm-12 col-md-6">
                            <p></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Plan</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <p class="reactivation-plan"><strong></strong></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Addons.</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 reactivation-addons">
                            <p>--</p>
                        </div>

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="button" class="btn lightbtn2 final-reactivation-complete" data-dismiss="modal" aria-label="Close"><span class="fas fa-check"></span> Mark As Re-Activated</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')

<script>
    $(function(){
        $(".reactivation-tab-btn").on("click", function() {
            loadReactivationData();
        });

        $('.for-reactivation-date-btn').on('click', function(e){
            e.preventDefault();
            loadReactivationData($(this).val());
        });

        function loadReactivationData(date = 0) {
            $('#for-reactivation-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{ URL::route('actionQueue.reactivation.datatables') }}",
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
                    { "data": 'name' },
                    { "data": 'phone-no' },
                    { "data": 'sim-num' },
                    { 
                        "data": 'plan',
                        "orderable": false,
                    },
                    {
                        "class": "reactivation-addons-data",
                        "data" : 'add-ons',
                        "orderable": false
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

        $('body').on('click', '.reactivation-completebtn', selectReactivationData)

        function selectReactivationData() {
            let $this = $(this).parents('tr');
            $('.selected-tr').removeClass('selected-tr');
            $this.addClass('selected-tr');
            let dataText = $this.find('.data-row').text();
            data = JSON.parse(dataText);
            let addons = $this.find('.reactivation-addons-data').text();
            $('.reactivation-id').val(data.id);
            $('.reactivation-name p').text(data.customer.full_name);
            $('.reactivation-phoneno p').text(data.phone_number_formatted);
            $('.reactivation-simcardno p').text(data.sim_card_num);
            $('.reactivation-plan strong').text(data.plans.name);
            $('.reactivation-addons p').text(addons);
        }

        $('.final-reactivation-complete').on('click', AjaxMarkReactivated)


        function AjaxMarkReactivated() {
            const formData = {id: $('.reactivation-id').val()};
            $.ajax({
                type: 'POST',
                url: '{{ route('reactivation.complete') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $('.selected-tr').addClass('display-none');
                    $('.dataTables_info').addClass('display-none');
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        };
    });
</script>

@endpush