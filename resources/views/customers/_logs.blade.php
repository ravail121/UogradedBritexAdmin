<div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src="{{ asset('theme/img/active_img.png') }}" width="11" height="11" alt=""/></span>Logs</h1>
                </div>
            </div>
        </div>
        
        <div class="subscribersdata billingdata">
            <div class="table-responsive">
                <table class="table audittable" id="all-log-table-wrapper">
                    <thead>
                        <tr>
                            <th scope="col" class="custom-width">Date</th>
                            <th scope="col" class="">Log</th>
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
            loadLog();
            function loadLog() {
                $('#all-log-table-wrapper').DataTable({
                    // "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                    // "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "info": true,
                    "bDestroy": true,
                    "order": [[ 1, "desc" ]],
                    "ajax": {
                        "url": "{{ URL::route('customer.log.datatable', $customer->id) }}",
                        beforeSend: showLoader,
                        complete: hideLoader,
                    },
                    "language": {
                        "processing": "Please Wait...",
                    },
                    "columns": [
                        { "data": 'created_at' },
                        { "data": 'content',
                            "orderable": 'false',
                        },
                    ],
                });
            }
        });
    </script>
@endpush