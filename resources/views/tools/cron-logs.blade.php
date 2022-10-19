@extends('layouts._app-auth')

@section('page-title')
    CRON Logs
@endsection

@section('content')

    <div class="table-responsive cron-logs-display mt-5">
        <div class="col-sm-12 col-md-2 col-lg-2">
            <div class="download-cron-logs-button-wrapper">
                <a class="btn download-cron-logs-button" href="javascript:void(0);">Export CSV</a>
            </div>
        </div>
        <table class="table audittable tablecentertxt" id="cron-logs-table">
            <thead>
            <tr>
                <th scope="col" class="">Name</th>
                <th scope="col" class="">Status</th>
                <th scope="col" class="">Response</th>
                <th scope="col" class="">Ran At</th>
                <th class="display-none"></th>
            </tr>
            </thead>
        </table>
    </div>

@endsection

@push('js')
    <script>
        $(function(){
            loadCronLogsData();

            $('.download-cron-logs-button').on('click', function() {
                var link = "{{ route('cron.get-cron-logs') }}";
                link += '?download=true';
                window.location = link;
            });

            function loadCronLogsData(date = 0) {
                $('#cron-logs-table').DataTable( {
                    "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                    "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "info": true,
                    "bDestroy": true,
                    "ajax": {
                        "url": "{{ route('cron.get-cron-logs') }}",
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
                        { "data": 'name'},
                        { "data": 'status' },
                        { "data": 'response' },
                        { "data": 'ran_at' },
                        {
                            "class": "display-none data-id",
                            "data": 'id',
                            "orderable": false,
                        }
                    ]
                });
            }
        });

    </script>
@endpush
