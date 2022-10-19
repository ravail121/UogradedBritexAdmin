<div class="tab-pane" id="cloudact" role="tabpanel" aria-labelledby="cloudact-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src="{{ asset("theme/img/icon_actiblu.png") }}" width="11" height="11" alt=""/></span>Cloud Activation</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="tabletags">
                        <p>Tags :</p>
                        <button type="button" class="btn cloud-activation-date-btn tag1" value = "1">Today</button>
                        <button type="button" class="btn cloud-activation-date-btn tag2" value = "2">1 Day</button>
                        <button type="button" class="btn cloud-activation-date-btn tag3" value = "3">2 Days</button>
                        <button type="button" class="btn cloud-activation-date-btn tag4" value = "4">3 Days</button>
                        <button type="button" class="btn cloud-activation-date-btn tag5" value = "5">4 Days</button>
                        <button type="button" class="btn cloud-activation-date-btn tag6" value = "0">5+ Days</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable tablecentertxt" id ="cloud-activation-table">
                    <thead>
                        <tr>
                            <th scope="col" class = ""></th>
                            <th scope="col" class = "custom-name">Name</th>
                            <th scope="col" class = "extra-sorting-width">Order Number</th>
                            <th scope="col" class = "extra-sorting-width">Area Code / Port No.</th>
                            <th scope="col" class = "extra-sorting-width">Sim Number</th>
                            <th scope="col" class = "custom-width">Tracking Number</th>
                            <th scope="col" class = "no-sort-option">Plan Type</th>
                            <th scope="col" class = "no-sort-option">Add-Ons</th>
                            <th scope="col" class = "no-sort-option">Action</th>
                            <th scope="col" class ="display-none"></th>
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
        $(".cloud-activation-tab-btn").on("click", function() {
            loadCloudActivationData();
        });

        $(".cloud-activation-date-btn").on("click", function(e) {
            e.preventDefault();
            loadCloudActivationData($(this).val());
        });

        function loadCloudActivationData(date = 0) {
            $('#cloud-activation-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{ URL::route('actionQueue.cloudactivation.datatables') }}",
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
                    { "data": 'porting-no' },
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
                ]
                
            });
        }
    });
</script>
@endpush