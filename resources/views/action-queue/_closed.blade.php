<div class="tab-pane" id="closed" role="tabpanel" aria-labelledby="closed-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src="{{ asset("theme/img/closed_img.png") }}" width="11" height="11" alt=""/></span>Confirm Closed</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="tabletags">
                        <p>Tags :</p>
                        <button type="button" class="btn closed-date-btn tag1" value = "1">Today</button>
                        <button type="button" class="btn closed-date-btn tag2" value = "2">1 Day</button>
                        <button type="button" class="btn closed-date-btn tag3" value = "3">2 Days</button>
                        <button type="button" class="btn closed-date-btn tag4" value = "4">3 Days</button>
                        <button type="button" class="btn closed-date-btn tag5" value = "5">4 Days</button>
                        <button type="button" class="btn closed-date-btn tag6" value = "0">5+ Days</button>
                    </div>
                    {{-- <div class="btns"> <a href="#" class="filterbtn"><span class="fas fa-filter"></span>Filter</a> </div> --}}
                </div>
            </div>
        </div>
        <div class="subscribersdata">
             <div class="table-responsive">
                <table class="table audittable" id="close-A-table">
                    <thead>
                        <tr>
                            <th scope="col" class=""></th>
                            <th scope="col" class="custom-name">Name</th>
                            <th scope="col" class="">Order Number</th>
                            <th scope="col" class="">Phone No</th>
                            <th scope="col" class="">Sim Number</th>
                            <th scope="col" class="custom-width">Plan</th>
                            <th scope="col" class="no-sort-option">Add-Ons</th>
                            <th scope="col" class="no-sort-option">Close Date</th>
                            <th scope="col" class="no-sort-option">Action</th>
                            <th scope="col" class="no-sort-option"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class = "closedline">
            <hr>
        </div>

        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src='{{ asset("theme/img/active_img.png") }}' width="11" height="11" alt=""/></span>Closed</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="tabletags">
                        <p>Tags :</p>
                        <button type="button" class="btn closed-B-date-btn tag1" value = "1">Today</button>
                        <button type="button" class="btn closed-B-date-btn tag2" value = "2">1 Day</button>
                        <button type="button" class="btn closed-B-date-btn tag3" value = "3">2 Days</button>
                        <button type="button" class="btn closed-B-date-btn tag4" value = "4">3 Days</button>
                        <button type="button" class="btn closed-B-date-btn tag5" value = "5">4 Days</button>
                        <button type="button" class="btn closed-B-date-btn tag6" value = "0">5+ Days</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable" id = "close-B-table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col" class="custom-name">Name</th>
                            <th scope="col">Order Number</th>
                            <th scope="col">Phone No</th>
                            <th scope="col">Sim Number</th>
                            <th scope="col" class="no-sort-option custom-width">Plan</th>
                            <th scope="col" class="no-sort-option">Add-Ons</th>
                            <th scope="col" class="no-sort-option">Close Date</th>
                            <th scope="col" class="no-sort-option">Action</th>
                            <th scope="col" class="no-sort-option"></th>
                        </tr>
                    </thead>
                </table>
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

@push('js')
<script>
    $(function(){
        $(".closed-tab-btn").on("click", function(e) {
            e.preventDefault();
            loadClosedData();
        });

        $(".closed-B-date-btn").on("click", function(e) {
            e.preventDefault();
            loadClosedBData($(this).val());
        });

        $(".closed-date-btn").on("click", function(e) {
            e.preventDefault();
            loadClosedAData($(this).val());
        });

        function loadClosedAData(date) {
            $('#close-A-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{ URL::route('actionQueue.closeA.datatables') }}",
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
                    { "data": 'order-number' },
                    { "data": 'phone-no' },
                    { "data": 'sim-num' },
                    {   
                        "data": 'plan',
                        "orderable": false,
                    },
                    {   
                        "data": 'add-ons',
                        "orderable": false,
                    },
                    {   
                        "data": 'close-date',
                        "orderable": false,
                    },
                    {   
                        "data": 'action',
                        "orderable": false,
                    },
                    {
                        "class": "display-none data-row",
                        "data" : 'id',
                        "orderable": false,
                    }, 
                ]
                
            });
        }

        function loadClosedData(date = 0) {
            loadClosedAData(date);
            loadClosedBData(date);
        }

        function loadClosedBData(date) {
            $('#close-B-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{ URL::route('actionQueue.closeB.datatables') }}",
                    "data": function ( d ) {
                        d.date = date;
                    },
                    beforeSend: showLoader,
                    complete: hideLoader,
                    error: function (xhr, status, error) {
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
                    { "data": 'order-number' },
                    { "data": 'phone-no' },
                    { "data": 'sim-num' },
                    {   
                        "data": 'plan',
                        "orderable": false,
                    },
                    {   
                        "data": 'add-ons',
                        "orderable": false,
                    },
                    {   
                        "data": 'close-date',
                        "orderable": false,
                    },
                    {
                        "data": 'action',
                        "orderable": false,
                    },
                    {
                        "class": "display-none data-row",
                        "data" : 'id',
                        "orderable": false,
                    }
                ]
                
            });
        }

        $('body').on('click', '.close-confirm-btn', ajaxUpdateClosed)

        function ajaxUpdateClosed() {
            formData = {
                id: $(this).parents('tr').find('.data-row').text()
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('update.closed') }}',
                dataType: 'json',
                data: formData,
                beforeSend: showLoader,
                success: function (data) 
                {
                    loadClosedData(0);
                },
                complete: hideLoader,
                error: function (xhr, status, error) {
                    firstXhrError(xhr);
                }
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
                        loadClosedData(0);
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
            var subscriptionId =  $(this).parents('tr').find('.data-row').text();
            $('.reopen-btn').attr('data-subscription-id', subscriptionId);
        });
    });
    
</script>
@endpush