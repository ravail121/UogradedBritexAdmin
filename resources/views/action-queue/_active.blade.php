<div class="tab-pane" id="active" role="tabpanel" aria-labelledby="active-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src='{{ asset("theme/img/active_img.png") }}' width="11" height="11" alt=""/></span>Active</h1>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="tabletags">
                        <button type="button" class="btn past-due-date-btn tag1" data-toggle="modal" data-target="#bulkNumberChangeModal">
                            <i class="fa fa-plus"></i> Bulk Number Change
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable tablecentertxt" id="active-table">
                    <thead>
                        <tr>
                            <th scope="col" class="no-sort-option"></th>
                            <th scope="col" class="custom-name">Name</th>
                            <th scope="col">Active Number</th>
                            <th scope="col">BAN</th>
                            <th scope="col" class="no-sort-option">Plan</th>
                            <th scope="col" class="no-sort-option custom-width">Add-Ons</th>
                            <th scope="col">Sim Number</th>
                            <th scope="col" class="active-activation">Activation Date</th>
                            <th scope="col" class="no-sort-option active-action">Action</th>
                            <th class ="no-sort-option display-none"></th>
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
                    <h1><span><img src='{{ asset("theme/img/icon_actiblu.png") }}' width="11" height="11" alt=""/></span>Pending Suspension</h1>
                </div>
            </div>
        </div>

        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable" id ="pending-suspension-table">
                    <thead>
                        <tr>
                            <th scope="col" class = "no-sort-option"></th>
                            <th scope="col" class = "custom-name">Name</th>
                            <th scope="col" class = "">Active Number</th>
                            <th scope="col" class = "">BAN</th>
                            <th scope="col" class = "no-sort-option">Plan</th>
                            <th scope="col" class = "no-sort-option custom-width">Add-Ons</th>
                            <th scope="col" class = "">Sim Number</th>
                            <th scope="col" class = " active-activation">Suspension Date</th>
                            {{-- <th scope="col" class = "no-sort-option active-action">Action</th> --}}
                            <th class = "no-sort-option display-none"></th>
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
                    <h1><span><img src='{{ asset("theme/img/closed_img.png") }}' width="11" height="11" alt=""/></span>Pending Close</h1>
                </div>
            </div>
        </div>

        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable" id ="pending-closed-table">
                    <thead>
                        <tr>
                            <th scope="col" class="no-sort-option"></th>
                            <th scope="col" class="custom-name">Name</th>
                            <th scope="col">Active Number</th>
                            <th scope="col">BAN</th>
                            <th scope="col" class="no-sort-option">Plan</th>
                            <th scope="col" class="no-sort-option custom-width">Add-Ons</th>
                            <th scope="col">Sim Number</th>
                            <th scope="col" class="active-activation">Close Date</th>
                            <th class ="no-sort-option display-none"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Activateline Popup Model modalsss -->
<div class="modal fade bd-example-modal-xl" id="bulkNumberChangeModal" tabindex="-1" role="dialog" aria-labelledby="bulkNumberChangeModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                        <h1>Bulk Number Change</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="bulk-number-change-form" type="multipart/form-data">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="bulk_csv">CSV</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <input type="file" id ="bulk_csv" name= "bulk_csv" class="form-control effect-1">
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <p class="mt-3"> <a href="{{ asset("csv/bulk_number_change.csv") }}" title="Download the sample CSV" target="_blank">Download the sample CSV</a></p>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="final-activation-btn check-phone-no btn lightbtn2"><span class="fas fa-power-off"></span>Bulk Number Change </button>
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
        $(".active-tab-btn").on("click", loadActiveTabData);

        function loadActiveTabData() {
            loadActiveData();
            loadPendingData('suspend-scheduled', '#pending-suspension-table');
            loadPendingData('close-scheduled', '#pending-closed-table');
        }

        function loadActiveData() {
            $('#active-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "order": [[ 7, "desc" ]],
                "ajax": {
                    url: "{{ URL::route('actionQueue.active.datatables') }}",
                    pages: 10,
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
                        "orderable": false,

                    },
                    {
                        "data": 'name',
                        "orderable": false
                    },
                    {
                        "data": 'phone_number'
                    },
                    {
                        "data": 'ban',
                        "orderable": false
                    },
                    {   
                        "data": 'plans',
                        "orderable": false,

                    },
                    {   
                        "data": 'add-ons',
                        "orderable": false,

                    },
                    { "data": 'sim_card_num' },
                    { "data": 'activation_date' },
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
        $('body').on('click', '.active-dropdown-option', function(e) {
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
            formData = {
                id: $this.find('.data-id').text(),
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
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        function loadPendingData(subStatus,tableId) {
            $(tableId).DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "order": [[ 7, "desc" ]],
                "ajax": { 
                    "url":"{{URL::route('actionQueue.active.datatables') }}",
                    data: function ( d ) {
                        d.sub_status = subStatus;
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
                        "orderable": false,

                    },
                    { "data": 'name' },
                    { "data": 'phone-no' },
                    { "data": 'ban' },
                    {   
                        "data": 'plans',
                        "orderable": false,

                    },
                    {   
                        "data": 'add-ons',
                        "orderable": false,

                    },
                    { "data": 'sim-num' },
                    {
                        "class": "date-row-drown",
                        "data" : 'date',
                    },
                    {
                        "class": "display-none data-id",
                        "data" : 'id',
                        "orderable": false,
                    },
                ]
            });
        }

        $('body').on('submit', '#bulk-number-change-form', function(e) {
            e.preventDefault();
            var form = $(this);
            validateBulkNumberChange(form);

            if (form.valid()) {
                AjaxBulkNumberChange(form);
            }
        });

        function validateBulkNumberChange(form) {
            form.validate({
                rules: {
                    bulk_csv: {
                        required:     true,
                        extension: 'csv'
                    },
                },
                messages: {
                    bulk_csv: {
                        required:      "Please upload the CSV file",
                        extension:     "The uploaded file must be a CSV file"
                    }
                },

                errorElement: "em",

                errorPlacement: function( error, element ){

                    $(element).addClass('is-invalid');
                    error.addClass('card-error');
                    error.insertAfter(element);
                    hideLoader();
                },
                success: function( label, element ){
                    $(element).removeClass("is-invalid");
                },
            });
        }

        function AjaxBulkNumberChange(form)
        {
            var formData = new FormData(form[0]);
            $.ajax({
                type: 'POST',
                url: "{{ route('subscription.bulk-number-change') }}",
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: showLoader,
                success: function (data) {
                    // $('.close').click();
                    if(data.hasOwnProperty('status') && data.status === 'success' && data.hasOwnProperty('messages')){
                        form[0].reset();
                        form.find('.invalid-feedback').remove();
                        form.find('.is-invalid').removeClass('is-invalid');
                        var message = data.messages.join(', ');
                        swal("Success!", message, "success");
                        loadActiveData();
                    }
                    if(data.hasOwnProperty('status') && data.status === 'error' && data.hasOwnProperty('message')){
                        form[0].reset();
                        swal("Error!", data.message, "error");
                    }

                    if(data.hasOwnProperty('status') && data.status === 'error' && data.hasOwnProperty('messages')){
                        form[0].reset();
                        form.find('.invalid-feedback').remove();
                        form.find('.is-invalid').removeClass('is-invalid');
                        var message = data.messages.join(', ');
                        swal("Error!", message, "error");
                    }
                },
                complete: hideLoader,
                error: function (xhr, status, error) {
                    firstXhrError(xhr);
                }
            });
        }
    });
</script>
@endpush