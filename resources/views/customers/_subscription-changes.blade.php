<div class="tab-pane fade" id="ach" role="tabpanel" aria-labelledby="ach-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src="{{ asset('theme/img/active_img.png') }}" width="11" height="11" alt="Audit Trail"></span>Audit Trail</h1>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table" id="subscription-changes-table-wrapper">
                    <thead>
                        <tr>
                            <th scope="col" class="custom-width">ID</th>
                            <th scope="col" class="custom-width">Change Type</th>
                            <th scope="col" class="custom-width">Description</th>
                            <th scope="col" class="custom-width">From</th>
                            <th scope="col" class="custom-width">To</th>
                            <th scope="col" class="custom-width">Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(function(){
            loadSubscriptionLogs();
            function loadSubscriptionLogs() {
                $('#subscription-changes-table-wrapper').DataTable({
                    "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                    "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "info": true,
                    "bDestroy": true,
                    "ajax": {
                        "url": "{{ url('subscription-logs-datatables') }}",
                        type: 'POST',
                        beforeSend: showLoader,
                        complete: hideLoader,
                        "data": function ( d ) {
                            d.customer_id = {{ $customer->id }};
                        }
                    },
                    "language": {
                        "processing": "Please Wait...",
                    },
                    "columns": [
                        {
                            "data": "id",
                        },
                        {
                            "data": 'change_type',
                            "orderable": 'false',
                            'class':'text-center',
                        },
                        {
                            "data": 'description',
                            "orderable": 'false',
                            'class':'text-center',
                        },
                        {
                            "data": 'from',
                            "orderable": 'false',
                            'class':'text-center',
                        },
                        {
                            "data": 'to',
                            "orderable": 'false',
                            'class':'text-center',
                        },
                        {
                            "data": 'date',
                            'class': 'text-center'
                        }
                    ],
                });
            }
        });
    </script>
@endpush