 <div class="tab-pane" id="finalsuspen" role="tabpanel" aria-labelledby="finalsuspen-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src='{{ asset("theme/img/final_img.png") }}' width="11" height="11" alt=""/></span>Confirm Suspended</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="tabletags">
                        <p>Tags :</p>
                        <button type="button" class="btn suspended-date-btn tag1" value = "1">Today</button>
                        <button type="button" class="btn suspended-date-btn tag2" value = "2">1 Day</button>
                        <button type="button" class="btn suspended-date-btn tag3" value = "3">2 Days</button>
                        <button type="button" class="btn suspended-date-btn tag4" value = "4">3 Days</button>
                        <button type="button" class="btn suspended-date-btn tag5" value = "5">4 Days</button>
                        <button type="button" class="btn suspended-date-btn tag6" value = "0">5+ Days</button>
                    </div>
                    {{-- <div class="btns"> <a href="#" class="filterbtn"><span class="fas fa-filter"></span>Filter</a> </div> --}}
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable" id ="suspended-B-table">
                    <thead>
                        <tr>
                            <th scope="col" class = ""></th>
                            <th scope="col" class = "custom-name">Name</th>
                            <th scope="col" class = "">Order Number</th>
                            <th scope="col" class = "">Phone No</th>
                            <th scope="col" class = "">Sim Number</th>
                            <th scope="col" class = "no-sort-option custom-width">Plan</th>
                            <th scope="col" class = "no-sort-option">Add-Ons</th>
                            <th scope="col" class = "">Suspension Date</th>
                            <th scope="col" class = "no-sort-option">Status</th>
                            <th scope="col" class = "no-sort-option">Action</th>
                            <th scope="col" class = "no-sort-option"></th>
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
                    <h1><span><img src='{{ asset("theme/img/active_img.png") }}' width="11" height="11" alt=""/></span>Suspended</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="tabletags">
                        <p>Tags :</p>
                        <button type="button" class="btn suspendedA-date-btn tag1" value = "1">Today</button>
                        <button type="button" class="btn suspendedA-date-btn tag2" value = "2">1 Day</button>
                        <button type="button" class="btn suspendedA-date-btn tag3" value = "3">2 Days</button>
                        <button type="button" class="btn suspendedA-date-btn tag4" value = "4">3 Days</button>
                        <button type="button" class="btn suspendedA-date-btn tag5" value = "5">4 Days</button>
                        <button type="button" class="btn suspendedA-date-btn tag6" value = "0">5+ Days</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable" id ="suspended-A-table">
                    <thead>
                        <tr>
                            <th scope="col" class = ""></th>
                            <th scope="col" class = "custom-name">Name</th>
                            <th scope="col" class = "">Order Number</th>
                            <th scope="col" class = "">Phone No</th>
                            <th scope="col" class = "">Sim Number</th>
                            <th scope="col" class = "no-sort-option custom-width">Plan</th>
                            <th scope="col" class = "no-sort-option">Add-Ons</th>
                            <th scope="col" class = "">Suspension Date</th>
                            <th scope="col" class = "no-sort-option">Status</th>
                            <th scope="col" class = "no-sort-option suspended-action">Action</th>
                            <th scope="col" class = "no-sort-option"></th>
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

        $(".suspended-tab-btn").on("click", function() {
            loadSuspendedData();
        });

        $(".suspended-date-btn").on("click", function(e) {
            e.preventDefault();
            loadSuspendedBData($(this).val());
        });

        $(".suspendedA-date-btn").on("click", function(e) {
            e.preventDefault();
            loadSuspendedAData($(this).val());
        });

        function loadSuspendedAData(date) {
            $('#suspended-A-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('actionQueue.suspendedA.datatables') }}",
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
                    { "data": 'suspended-date' },
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

        function loadSuspendedBData(date) {
            $('#suspended-B-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('actionQueue.suspendedB.datatables') }}",
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
                        "data": 'suspended-date'
                    },
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
                    }
                ]
                
            });
        }

        function loadSuspendedData(date = 0) {
            loadSuspendedAData(date);
            loadSuspendedBData(date);
        }
         
        $('body').on('click', '.confirm-suspended-btn', ajaxUpdateSuspendedClosed);

        function ajaxUpdateSuspendedClosed(e) {
            e.preventDefault();
            $this = $(this).parents('tr');
            formData = {
                id: $this.find('.data-id').text(),
                date: $this.find('.suspended-date').val()
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('update.suspended.close') }}',
                dataType: 'json',
                data: formData,
                beforeSend: showLoader,
                success: function (data) 
                {
                    loadSuspendedData(0);
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        
        $('body').on('click', '.suspended-close-btn', function (e) {
            e.preventDefault();
            $this = $(this).parents('td');
            $this.find('.suspended-action-btn').addClass('display-none');
            $this.find('.suspended-confirm-btn').removeClass('display-none');
            let today = new Date();
            let maxDate = new Date($this.find('.billind-cycles').attr('data-date'));
            // maxDate.setDate(maxDate.getDate()+31);
            $this.find('.date').datepicker({ 
                autoclose: true, 
                todayHighlight: true,
                format: 'mm/dd/yyyy',
                startDate: today,
                endDate: maxDate
            }).datepicker('update', today);
        });

        $('body').on('click', '.suspendedB-confirm-btn', ajaxUpdateSuspendedB);

        function ajaxUpdateSuspendedB(e) {
            e.preventDefault();
            $this = $(this).parents('tr');
            formData = {id: $this.find('.data-id').text()
            };

            $.ajax({
                type: 'POST',
                url: '{{ route('update.SuspendedB') }}',
                dataType: 'json',
                data: formData,
                beforeSend: showLoader,
                success: loadSuspendedData(0),
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }


        $('body').on('click', '.suspended-confirm-close-btn', function(e){
            e.preventDefault();
            $this = $(this).parents('td');
            $this.find('.suspended-action-btn').removeClass('display-none');
            $this.find('.suspended-confirm-btn').addClass('display-none')
        });
        
        $('body').on('click', '.suspended-unsuspend-btn', ajaxUpdateUnsuspendSuspended)

        function ajaxUpdateUnsuspendSuspended(e) {
            e.preventDefault();
            $this = $(this);
            formData = {id: $this.parents('tr').find('.data-id').text()
            };
            if($this.attr('data-row') == "1"){
                alert("You must activate this line directly (it will not go into the FOR RESTRATION que)");
                $.ajax({
                    type: 'POST',
                    url: '{{ route('update.account.suspended') }}',
                    dataType: 'json',
                    data: formData,
                    beforeSend: showLoader,
                    success: loadSuspendedData(0),
                    complete: hideLoader,
                    error: function (xhr,status,error) {
                        firstXhrError(xhr);
                    }
                });
            }else{
                $.ajax({
                    type: 'POST',
                    url: '{{ route('update.unsuspend') }}',
                    dataType: 'json',
                    data: formData,
                    beforeSend: showLoader,
                    success: loadSuspendedData(0),
                    complete: hideLoader,
                    error: function (xhr,status,error) {
                        firstXhrError(xhr);
                    }
                });
            }
        }
    });
    
</script>

@endpush