<div class="tab-pane fade" id="eh" role="tabpanel" aria-labelledby="eh-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src="{{ asset('theme/img/active_img.png') }}" width="11" height="11" alt=""/></span>Email History</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="btns">
                        <button type="button" class="btn btn1" data-toggle="modal" data-target="#composemsg"><span class="fas fa-pencil-alt"></span>Compose</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable" id="all-email-log-table">
                    <thead>
                        <tr>
                            <th scope="col" class="custom-agent-width">Agent</th>
                            <th scope="col" class="custom-width">Subject</th>
                            <th scope="col">Email</th>
                            <th scope="col" class="custom-width">Date Sent</th>
                            <th scope="col" class="custom-width">Description</th>
                            <th scope="col" class="custom-width">Action</th>
                            <th scope="col" class="display-none"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="composemsg" tabindex="-1" role="dialog" aria-labelledby="composemsg" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close update-customer-close-btn" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                        <h1>Compose Email</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id = "email-history-form" class="customer-update">
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                    <input type="hidden" name="staff_id" value="{{ $user->id }}">
                    <input type="hidden" name="compose" value="composeEmail">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                            <label for ="name">From</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <span class="form-control effect-1">{{ $customer->company->support_email }}</span>
                            <input type="hidden" name="from" id="from" class="form-control effect-1" placeholder="From" value="{{$customer->company->support_email}}">
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <label for ="name">To</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <span class="form-control effect-1">{{ $customer->email }}</span>
                            <input type="hidden" name="to" id="to" class="form-control effect-1" placeholder="To" value="{{$customer->email}}">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for ="name">Cc</label>
                            <input type="text" name="cc" id="cc" class="form-control effect-1" placeholder="Cc">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for ="name">Bcc</label>
                             <input type="text" name="bcc" id="bcc" class="form-control effect-1" placeholder="Bcc">
                            <span class="focus-border"></span>
                        </div>

                        <div class="form-group col-sm-12 col-md-12">
                            <label for ="name">Responses</label>
                            <select class="custom-select effect-1 cannedResponse" id="compose_canned_response" name='canned_response_id'>
                            <option value="" disabled selected data-body="">Please Select</option>
                            @foreach($cannedResponse as $canned)
                                <option value="{{ $canned['id'] }}" data-body="{{ $canned['body'] }}" data-subject="{{ $canned['subject'] }}" >{{ $canned['name'] }}</option>
                            @endforeach
                            </select>                 
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <label for ="name">Subject</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <input type="text" name="subject" id="subject" class="form-control effect-1" placeholder="Subject">
                            <span class="focus-border"></span>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <label>Body:-</label>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <textarea name="body" id="body">
                            </textarea>
                            <p id="notes-error" class="error card-error body-error display-none">Please provide email body</p>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">Send</button>
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
            function format (data) {
                data = JSON.parse(data);
                return '<tr id="emailbxall" class="collapse show">'+
                            '<td colspan="8">'+
                                '<table>'+
                                    '<td colspan="8" class="topbtmshadow">'+
                                        '<div class="emailbx">'+
                                            '<div class="emailhdr">'+
                                                '<div class="row">'+
                                                    '<div class="col-sm-6 col-md-6">'+
                                                        '<div class="emailusermails">'+
                                                            '<h1>'+data.subject+'</h1>'+
                                                            '<p>From: <a href="/cdn-cgi/l/email-protection#93f2fdfdf2e0fefae7fbd3f4fef2faffbdf0fcfe"><span class="__cf_email__" data-cfemail="18797676796b75716c70587f75797174367b7775">'+data.from+'</span></a></p>'+
                                                            '<p class="time">'+data.created_at+'</p>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="emailcontent">'+
                                                data.body
                                            '</div>'+
                                        '</div>'+
                                    '</td>'+
                                '</table>'+
                            '</td>'+
                        '</tr>';
            }
            loadEmailLog();
            $toolbar = [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList' ]

            ClassicEditor.create( document.querySelector( '#email-history-form #body' ),{
                toolbar: $toolbar,
            } )
            .catch( error => {
                console.error( error );
            } );

            function loadEmailLog() {
                let dt = $('#all-email-log-table').DataTable({
                    "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                    "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "info": true,
                    "bDestroy": true,
                    "order": [[ 3, "desc" ]],
                    "ajax": {
                        "url": "{{URL::route('email.log.datatable', $customer->id) }}",
                        beforeSend: showLoader,
                        complete: hideLoader,
                    },
                    "language": {
                        "processing": "Please Wait...",
                    },
                    "columns": [
                        { 
                            "data": 'agent',
                            'class' :'text-center',
                        },
                        { "data": 'subject' },
                        { "data": 'to' },
                        { "data": 'created_at' },
                        { "data": 'body',
                            "orderable": 'false',
                        },
                        { 
                            "data": 'modify',
                            "orderable": false,
                        },
                        { 
                            "data": 'all-data',
                            "orderable": false,
                            'class' :'display-none data-row',
                        },
                    ],
                });

                let detailRows = [];

                    $('#all-email-log-table').on( 'click', 'tr td a.more-btn', function () {
                        let tr = $(this).closest('tr');
                        let row = dt.row( tr );
                        let data = $(this).parents('tr').find('.data-row').text();
                        if ( row.child.isShown() ) {
                            // This row is already open - close it
                            row.child.hide();
                            tr.removeClass('shown');
                        }
                        else {
                            // Open this row
                            row.child( format(data)).show();
                            tr.addClass('shown');
                        }
                    });
            }
            $('body').on('submit', '#email-history-form', function(e) {
                e.preventDefault();
                validateComposeEmailForm();
                if ($('#email-history-form').valid()) {
                    if(!$('#email-history-form #body').val()){
                        $('#email-history-form .body-error').removeClass('display-none');
                    }else{
                        $('#email-history-form .body-error').addClass('display-none');
                        addEmailHistory();
                    }
                }
            });

            function addEmailHistory() {
                let formData = $('#email-history-form').serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('add.email.log') }}',
                    dataType: 'json',
                    data:formData,
                    beforeSend: showLoader,
                    success: function (data) {
                        swal("Success!",'Email Sent Sucessfully!' , "success");
                        $('.close').click();
                        $('#all-email-log-table').DataTable().ajax.reload();
                        //loadEmailLog();
                    },
                    complete: hideLoader,
                    error: function (xhr,status,error) {
                        firstXhrError(xhr);
                    }
                });
            }

            function validateComposeEmailForm() {
                $('#email-history-form').validate({
                    rules: {
                        from:               "required",
                        to:                 "required",
                        subject:            "required",
                        body:               "required",
                    },
                    messages: {
                        from:               "Please provide From Email",
                        to:                 "Please provide To Email",
                        subject:            "Please provide Subject",
                        body:               "Please provide Body",
                    },

                    errorElement: "em",

                    errorPlacement: function( error, element ){

                        $(element).addClass('is-invalid');
                        error.addClass('card-error');
                        error.insertAfter(element);
                    },
                    success: function( label, element ){
                        $(element).removeClass("is-invalid");
                    },
                });
            }

            $('#email-history-form').on('change', '#compose_canned_response', function(e) {
                e.preventDefault();
                $this = $(this).find(':selected');
                $('#email-history-form #subject').val($this.attr('data-subject'));
                $('.ck-editor').empty();
                $('#email-history-form #body').val($this.attr('data-body'));
                
                ClassicEditor.create( document.querySelector( '#email-history-form #body' ),{
                    toolbar: $toolbar,
                } )
                .catch( error => {
                    console.error( error );
                } );
            });

        });
    </script>
@endpush