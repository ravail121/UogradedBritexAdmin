<div class="tab-pane" id="forsusp" role="tabpanel" aria-labelledby="forsusp-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src='{{ asset("theme/img/icon_acti.png") }}' width="11" height="11" alt=""/></span>Past Due</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="tabletags">
                        <p>Tags :</p>
                        <button type="button" class="btn past-due-date-btn tag1" value = "1">Today</button>
                        <button type="button" class="btn past-due-date-btn tag2" value = "2">1 Day</button>
                        <button type="button" class="btn past-due-date-btn tag3" value = "3">2 Days</button>
                        <button type="button" class="btn past-due-date-btn tag4" value = "4">3 Days</button>
                        <button type="button" class="btn past-due-date-btn tag5" value = "5">4 Days</button>
                        <button type="button" class="btn past-due-date-btn tag6" value = "0">5+ Days</button>
                    </div>
                    {{-- <div class="btns"> <a href="#" class="filterbtn"><span class="fas fa-filter"></span>Filter</a> </div> --}}
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable" id ="past-due-table">
                    <thead>
                        <tr>
                            <th scope="col" class = ""></th>
                            <th scope="col" class = "custom-name">Name</th>
                            <th scope="col" class = "">Order Number</th>
                            <th scope="col" class = "">Phone No</th>
                            <th scope="col" class = "">Sim Number</th>
                            <th scope="col" class = " custom-width no-sort-option">Plan</th>
                            <th scope="col" class = "no-sort-option">Add-Ons</th>
                            <th scope="col" class = "">Suspension Date</th>
                            <th scope="col" class = "no-sort-option">Status</th>
                            <th scope="col" class = "no-sort-option past-due-action ">Action</th>
                            <th class = "no-sort-option display-none"></th>
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
        $(".past-due-tab-btn").on("click", function() {
            loadPastDueData();
        });

        $(".past-due-date-btn").on("click", function(e) {
            e.preventDefault();
            loadPastDueData($(this).val());
        });
        

        function loadPastDueData(date = 0) {
            $('#past-due-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('actionQueue.pastdue.datatables') }}",
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
                        "class": "active-custom-image date-icon",
                        "data" : 'first',
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
                    { "data": 'suspension-date' },
                    {   
                        "data": 'status',
                        "orderable": false,

                    },
                    {   
                        "data": 'action',
                        "orderable": false,

                    },
                    {
                        "class": "display-none data-id",
                        "data" : 'id',
                        "orderable": false,
                    },
                ]
                
            });
        }
        
        // $('body').on('click', '.final-past-due-btn', function(){
        //     $(this).parents('tr').addClass('display-none');
        //     $('#past-due-table_info').addClass('display-none');
        // });

    });
</script>
@endpush