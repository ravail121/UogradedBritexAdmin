<div class="tab-pane" id="porting" role="tabpanel" aria-labelledby="porting-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src='{{ asset("theme/img/icon_acti.png") }}' width="11" height="11" alt=""/></span>Porting</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="tabletags">
                        <p>Tags :</p>
                        <button type="button" class="btn porting-date-btn tag1" value = "1">Today</button>
                        <button type="button" class="btn porting-date-btn tag2" value = "2">1 Day</button>
                        <button type="button" class="btn porting-date-btn tag3" value = "3">2 Days</button>
                        <button type="button" class="btn porting-date-btn tag4" value = "4">3 Days</button>
                        <button type="button" class="btn porting-date-btn tag5" value = "5">4 Days</button>
                        <button type="button" class="btn porting-date-btn tag6" value = "0">5+ Days</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribersdata ">
            <div class="table-responsive">
                <table class="table audittable tablecentertxt" id="porting-table">
                    <thead>
                        <tr>
                            <th scope="col" class = ""></th>
                            <th scope="col" class = "custom-name">Name</th>
                            <th scope="col" class = "">Current Phone No.</th>
                            <th scope="col" class = "">Phone No. To Port</th>
                            <th scope="col" class = "">Sim Number</th>
                            <th scope="col" class = "no-sort-option custom-width">Status</th>
                            <th scope="col" class = "no-sort-option">Action</th>
                            <th class="display-none no-sort-option"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Port Popup Model modal -->
<div class="modal fade bd-example-modal-lg" id="portpopup" tabindex="-1" role="dialog" aria-labelledby="portpopup" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx">
                        <h1>Send Port Request</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="port-info" class="port-info padding-none">
                    <input type="hidden" class="port-id" id="id" name ="id" readonly>
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="authorized_name">Authorized Name<span class="text-danger"> *</span></label>
                            <input type="text" id="authorized_name" name ="authorized_name" class=" effect-1" placeholder="Please Enter Authorized Name">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="address_line1">Address Line 1<span class="text-danger"> *</span></label>
                            <input type="text" id="address_line1" name="address_line1" class=" effect-1" placeholder="Address Line 1">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="address_line2">Address Line 2</label>
                            <input type="text" id ="address_line2" name="address_line2" class=" effect-1" placeholder="Address Line 2">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="city">City<span class="text-danger"> *</span></label>
                            <input type="text" id="city" name="city" class=" effect-1" placeholder="Please Enter City">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="state">State<span class="text-danger"> *</span></label><br>
                            {!! Form::select('state', $states, null, ['class' => 'width-100', 'id'=>'state']) !!}
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="zip">Zip Code<span class="text-danger"> *</span></label>
                            <input type="text" id="zip" name="zip" class=" effect-1" placeholder="Zip">
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="ssn_taxid">SSN/Tax ID(Optional)</label>
                            <input type="text" id="ssn_taxid" name="ssn_taxid" class=" effect-1" placeholder="SSN/Tax ID(Optional)">
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="sim_card_number">SIM Card Number</label>
                            <input type="text" id="sim_card_number" name="sim_card_number" class=" effect-1" placeholder="SIM Card Number" disabled>
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="number_to_port">Number to Port<span class="text-danger"> *</span></label>
                            <input type="text" id ="number_to_port" name ="number_to_port" class=" effect-1" placeholder="Number to Port" maxlength="10">
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="company_porting_from">Phone Company you are porting from<span class="text-danger"> *</span> </label>
                            <input type="text" id="company_porting_from" name="company_porting_from" class=" effect-1" placeholder="">
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="account_number_porting_from">Account Number of former carrier<span class="text-danger"> *</span></label>
                            <input type="text" id="account_number_porting_from" name="account_number_porting_from" class=" effect-1" placeholder="">
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="account_pin_porting_from">Account Pin of former carrier<span class="text-danger"> *</span> </label>
                            <input type="text" id="account_pin_porting_from" name="account_pin_porting_from" class=" effect-1" placeholder="">
                            <span class="focus-border"></span> </div>

                        <div class="form-group col-sm-12 col-md-12 mt-4 text-right">
                            <button type="submit" class="btn lightbtn final-port-submit-btn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Porting Error Popup Message Popup Model modal -->
<div class="modal fade bd-example-modal-lg" id="portingerrorpop" tabindex="-1" role="dialog" aria-labelledby="portingerrorpop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx redbg" style="margin:0 0 40px 0;">
                        <h1>Porting Error</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="port-reject-form">
                    <input type="hidden" class = "allPortData">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Email Address</label>
                            <input type="text" class="port-rejected-email form-control effect-1" placeholder="" disabled>
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label>Response</label>
                            {{ Form::select(
                                'response',
                                $cannedResponse ,
                                null,
                                ['class' => 'custom-select effect-1 port-reject-selectbox', 'required']
                            ) }}
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 textarean">
                            <label>Subject</label>
                            <textarea class="form-control textaream  effect-1 port-reject-subject" name="subject" id="subject" rows="1" placeholder="" required ></textarea>
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 textarean">
                            <label>Message</label>
                            <textarea class="form-control textaream  effect-1 port-reject-message" name="message"
                                      id="message" rows="3" placeholder="Tell something....." required ></textarea>
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 text-right">
                            <button type="submit" class="btn lightbtn final-port-reject"><span class="fas fa-paper-plane"></span>Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="//cdn.ckeditor.com/ckeditor5/12.1.0/classic/ckeditor.js"></script>

    <script>
    $(function(){
        formValidate();

        $(".porting-tab-btn").on("click", function() {
            loadPortingData();
        });

        $(".porting-date-btn").on("click", function(e) {
            e.preventDefault();
            loadPortingData($(this).val());
        });

        function loadPortingData(date = 0) {
            $('.close').click()
            $('#porting-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{ URL::route('actionQueue.porting.datatables') }}",
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
                    { "data": 'current-phone-no' },
                    { "data": 'phone-no-to-port' },
                    { "data": 'sim-num' },
                    {   "data": 'status',
                        "orderable": false,
                    },
                    {
                        "class": "porting-action",
                        "data" : 'action',
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

        $('body').on('click', '.complete-btn', showConfirm);
        function showConfirm() {
            var $this = $(this).parents('td');
            $this.find('.combbtnsgroup').addClass('display-none-imp');
            $this.find('.port-confirm-btn').removeClass('display-none-imp');
        }

        $('body').on('click', '.port-confirm-close-btn', showCompBtn);

        function showCompBtn() {
            var $this = $(this).parents('td');
            $this.find('.port-confirm-btn').addClass('display-none-imp');
            $this.find('.combbtnsgroup').removeClass('display-none-imp');
        }

        $('body').on('click', '.confirm-port-btn', confirmPortAjax);

        function confirmPortAjax() {
            var $this = $(this).parents('td');
            var mail = false;
            if(!$this.find('input').prop("checked")){
                mail = true;
            }
            var dataText = $this.parents('tr').find('.data-row').text();
            var data = JSON.parse(dataText);
            
            var formData = {
                id: data.id,
                phone_number: data.number_to_port,
                customer_id: data.subscription.customer_id,
                mail: mail
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('port.complete') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    loadPortingData();
                    swal("Port Status  Updated!", "", "success");
                    // $this.find('.actionbtn').addClass('display-none-imp');
                    // $this.parents('tr').find('.erooroutdiv').html('<span class="complete smbtn80">Complete</span>');
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        $('body').on('click', '.port-reject-btn', loadData);

        function loadData() {
            var $this = $(this);
            $('.selected-rejected-port').removeClass('selected-rejected-port');
            $('.selected-port-status').removeClass('selected-port-status');
            $this.parents('td').addClass('selected-rejected-port');
            $this.parents('tr').find('.erooroutdiv').addClass('selected-port-status');
            getResponseDataAjax();
            let dataText = $(this).parents('tr').find('.data-row').text();
            $('.allPortData').val(dataText);
            var data = JSON.parse(dataText);
            $('.port-rejected-email').val(data.subscription.customer.email)
        }

        $('body').on('change', '#statusdropdown', function(e) {
            var status = $(this).val();
            var dataText = $(this).parents('tr').find('.data-row').text();
            $('.allPortData').val(dataText);
            var data = JSON.parse(dataText);
            if(status == '4'){
                getResponseDataAjax();
                $('.port-rejected-email').val(data.subscription.customer.email)
                $('#portingerrorpop').modal('show');
            }else{
                updateStatusAjax(status, data.id);
            }
        });

        function updateStatusAjax(status, id) {
            var formData = {
                id: id,
                status: status
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('update.port.status') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    loadPortingData();
                    swal("Port Status Updated!", "", "success");
                },
                complete: hideLoader,
                error: function (xhr, status, error) {
                    firstXhrError(xhr);
                }
            });
        }

        $('body').on('submit', '#port-reject-form', function(e) {
            e.preventDefault();
            rejectPortAjax();
        });

        function rejectPortAjax() {
            var portDataText = $('.allPortData').val();
            data = JSON.parse(portDataText);

            var formData = {
                id: data.id,
                subject: $('.port-reject-subject').val(),
                message: $('.port-reject-message').val(),
                customer_id: data.subscription.customer_id
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('port.reject') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $('#portingerrorpop').modal('toggle');
                    loadPortingData();
                    swal("Port Request Rejected!", "", "success");
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        $('.port-reject-selectbox').on('change', getResponseDataAjax);

        function getResponseDataAjax() {
            var id = $('.port-reject-selectbox').val();
            var formData = {
                id: id
            };
            $.ajax({
                type: 'POST',
                url: '{{ route('get.response.data') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $('.port-reject-subject').val(data.subject);
                    $('.port-reject-message').val(data.body);
                    if ($('.ck-rounded-corners').length) {
                        $('.ck.ck-reset.ck-editor.ck-rounded-corners').remove();
                    }
                    const $toolbar = ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList'];
                    ClassicEditor.create(document.querySelector('#message'), {
                        toolbar: $toolbar,
                    })
                        .catch(error => {
                            console.error(error);
                        });
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        function formValidate() {
            $('.port-info').validate({
                rules: {
                    authorized_name: {
                        required:  true,
                        maxlength:  20,
                    },
                    zip: {
                        required:   true,
                        minlength:  5,
                        maxlength:  5,
                        number:     true   
                    },
                    address_line1: {
                        required:   true,   
                    },
                    city: { 
                        required:   true,
                        maxlength:  20, 
                    },
                    state: {
                        required:   true,  
                    },
                    number_to_port: {
                        required:   true,
                        minlength:  10,
                        maxlength:  10,
                        number:     true,
                        remote :{
                            url: "{{ route('check.number') }}",
                            type: "post"
                        } 
                    },
                    company_porting_from: {
                        required:   true,
                    },
                    account_number_porting_from: {
                        required:   true,
                        digits:     true
                    },
                    account_pin_porting_from: {
                        required:   true,
                        digits:     true
                    },
                },
                messages: {
                    authorized_name:{
                        required:          "Please provide Authorized Name.",
                        maxlength:          "Authorized name can't be so long"
                    },
                    zip:{
                        required:          "Please provide Pin",
                        minlength:         "Zip must be of 5 digit",
                        maxlength:         "Zip must be of 5 digit",
                    },
                    address_line1:          "Please provide Address.",
                    city:{
                        required:          "Please provide city.",
                        maxlength:         "City name can't be so long"
                    },
                    state:                  "Please provide state Name.",
                    number_to_port:{
                        required:          "Please provide Number to port.",
                        number:            "Must be numeric number",
                        minlength:         "Number must be of 10 digit",
                        maxlength:         "Number must be of 10 digit",
                        remote:            "Number already Active",
                    },
                    company_porting_from:  "Please provide company Name.",
                    account_pin_porting_from:    {
                        required:        "Please provide company Name.",
                        digits:          "Account Pin should contain only digits"
                    },
                    account_number_porting_from:    {
                        required:        "Please provide Authorized Name.",
                        digits:          "Account Number should contain only digits"
                    }
                },

                errorElement: "em",

                errorPlacement: function( error, element ){
                    $(element).addClass('is-invalid');
                    error.addClass('form-text text-muted text-danger');
                    error.insertAfter(element);
                },
                success: function( label, element ){
                    $(element).removeClass("is-invalid");
                },
            });
        };

        $('body').on('click', '.eyeviewbtn', function(f) { 
            var data = JSON.parse($(this).parents('tr').find('.data-row').text());
            $('#id').val(data.id);
            $('#authorized_name').val(data.authorized_name);
            $('#address_line1').val(data.address_line1);
            $('#address_line2').val(data.address_line2);
            $('#city').val(data.city);
            $('#zip').val(data.zip);
            $('#state').val(data.state);
            $('#ssn_taxid').val(data.ssn_taxid);
            $('#number_to_port').val(data.number_to_port);
            $('#company_porting_from').val(data.company_porting_from);
            $('#account_number_porting_from').val(data.account_number_porting_from);
            $('#status').val(data.status);
            $('#account_pin_porting_from').val(data.account_pin_porting_from);
            $('#sim_card_number').val(data.subscription.sim_card_num);
        });

        $('body').on('submit', '#port-info', function(f) {
            f.preventDefault();
            if ($('.port-info').valid()) {
                updatePortAjax();
            }
        });

        function updatePortAjax() {
            var formData = $('#port-info').serialize();

            $.ajax({
                type: 'POST',
                url: '{{ route('update.port') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $('#portpopup .close').click();
                    loadPortingData();
                },
                complete: hideLoader,
                error: function (xhr, status, error) {
                    firstXhrError(xhr);
                }
            });
        };
    });
</script>
@endpush
