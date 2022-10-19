@extends('layouts._app-auth')
@push('css')
    <style>
        .dynamicFields {
            border: 1px solid;
            display: block;
        }

    </style>
@endpush
@section('page-title')
   Email Template
@endsection

@section('content')
<div class="subscbx bgwhite">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
                <h1><span><img src="{{ asset("theme/img/active_img.png") }}" width="11" height="11" alt=""/></span>Email Template</h1>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
                <div class="actionbtn"> 
                    <a class="btn markbtn createbtn create-temp-btn" href="#createpopup" data-toggle="modal" data-target="#createpopup">Add New</a> 
                </div>
            </div>
        </div>
    </div>
    <div class="subscribersdata">
        <div class="table-responsive">
            <table class="table audittable tablecentertxt" id="email-template-table">
                <thead>
                    <tr>
                        <th scope="col" class="custom-width">ID</th>
                        <th scope="col">Code</th>
                        <th scope="col" class="custom-name-width">From</th>
                        <th scope="col">To</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Body</th>
                        <th scope="col">Modify</th>
                        <th scope="col" class="display-none"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="updateshipping" tabindex="-1" role="dialog" aria-labelledby="updateshipping" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close edit-model-close-btn" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                        <h1>Edit Email Template</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="edit-email-template-form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="" placeholder="">
                    <div class="row">
                        @include('email-template.partials._emailtemplateform', ['form' => ''])

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="createpopup" tabindex="-1" role="dialog" aria-labelledby="createpopup" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx margin-bottom40">
                        <h1>Add New Email Template</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="add-email-template-form"  method="post" enctype="multipart/form-data">
                    <div class="row">

                        @include('email-template.partials._emailtemplateform', ['form' => 'create'])

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">Create Email Template</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="device-image" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <div class="modal-body">
            <img class="model-device-image" src="">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
  </div>
</div>
@endsection
@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/12.1.0/classic/ckeditor.js"></script>
    <script>
        $(function(){
            let placeholder = $('#placeholder').attr('data-row');
            let customPlaceholder = $('#custom-place-holder').attr('data-row');

            function loadPlaceholderData(placeholder, codeValue, customPlaceholder) {
                $('.dynamicFields').html('');
                $.each(JSON.parse(customPlaceholder), function(key, value){
                    if(codeValue == key) {
                        $placeholder ='<b class ="placeholder-name">'+value+'</b>';
                        $('.dynamicFields').append($placeholder);
                        return false;
                    }
                });
                $.each(JSON.parse(placeholder), function(i, value){
                    $.each(value.code, function(i, code){
                        if(code == codeValue) {
                            let holders = "";
                            $.each(value.name, function(j, name){
                                const valueTable = "'" + '['+value.table+'__'+name+']' + "'";
                                holders += '<li class="d-flex justify-content-between">' +
                                    '<div>' + '['+value.table+'__'+name+']' + '</div>' +
                                '<div class="btn btn-sm" onclick="copyTextToClipboard('+ valueTable + ')">Copy</div>' +
                                    '</li>';
                            })
                            $row = '<div class="dropdown">\
                                <p class="dropdown-toggle table-btn" type="button" data-toggle="dropdown">'+value.table+'\
                                <span class="caret"></span></p>\
                                <ul class="dropdown-menu column-name">\
                                '+holders+'\
                                </ul>\
                            </div>'

                            $('.dynamicFields').append($row);
                        } 
                    });
                });
            }            
            
            $('.code').on('change',function() {
                $('.codeValues').remove();
                var code = $(this).val();
                loadPlaceholderData(placeholder, code, customPlaceholder);
            });

            loadEmailTemplateData();

            $( '.modal' ).modal( {
                focus: false,
                show: false
            } );

            $toolbar = [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList' ]

            ClassicEditor.create( document.querySelector( '#add-email-template-form #body' ),{
                toolbar: $toolbar,
            } )
            .catch( error => {
                console.error( error );
            } );

            function loadEmailTemplateData() {
                $('#email-template-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{ URL::route('email.template.datatable') }}",
                    beforeSend: showLoader,
                    complete: hideLoader,
                },
                "language": {
                    "processing": "Please Wait...",
                },
                "columns": [
                    { 
                        "data": 'id',
                        'class' :'text-center',
                    },
                    { 
                        "data": 'code',
                        'class' :'text-center',
                    },
                    { "data": 'from' },
                    { "data": 'to' },
                    { "data": 'subject' },
                    { "data": 'body' },
                    { 
                        "data": 'modify',
                        "orderable": false,
                    },
                    { 
                        "data": 'all-data',
                        "orderable": false,
                        'class' :'display-none data-row',
                    },
                ]
            });
            }

            $('body').on('click', '.edit-btn', function(e) {
                e.preventDefault();
                let data = $(this).parents('tr').find('.data-row').text();
                $('.codeValues').remove();
                var code = JSON.parse(data);
                loadPlaceholderData(placeholder, code.code, customPlaceholder);
                setValue(data);
            });

            $('body').on('click', '.create-temp-btn', function(e) {
                e.preventDefault();
                var code = $("#createcode").val();
                loadPlaceholderData(placeholder, code, customPlaceholder);
            });

            $('body').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Do You really want to delete this template",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        deleteDevice($(this).attr('data-id')) 
                    }
                });
            });

            function setValue(data) {
                data = JSON.parse(data);
                const $form = $('#edit-email-template-form');
                $form.find('.ck-editor').empty(); 
                $form.find('#id').val(data.id);
                $form.find('#code').val(data.code);
                $form.find('#from').val(data.from);
                $form.find('#to').val(data.to);
                $form.find('#subject').val(data.subject);
                $form.find('#body').val(data.body);
                $form.find('#cc').val(data.cc);
                $form.find('#bcc').val(data.bcc);
                $toolbar = [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList' ]

                ClassicEditor.create( document.querySelector( '#edit-email-template-form #body' ),{
                    toolbar: $toolbar,
                } )
                .catch( error => {
                    console.error( error );
                } );

            }

            $('body').on('submit', '#edit-email-template-form', function(e) {
                e.preventDefault();
                $form = $('#edit-email-template-form');
                validateForm($form);
                if ($('#edit-email-template-form').valid()) {
                    if(!$('#body').val()){
                        $('.body-error').removeClass('display-none');
                    }else{
                        $('.body-error').addClass('display-none');
                        editEmailTemplate();            
                    }
                }
            });


            function editEmailTemplate() {
                let formData = $('#edit-email-template-form').serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('edit.email.template') }}',
                    dataType: 'json',
                    data:formData,
                    beforeSend: showLoader,
                    success: function (data) {
                        swal("Success!",'Email Template Sucessfully Edited!' , "success");
                        $('.edit-model-close-btn').click();
                        loadEmailTemplateData();   
                    },
                    complete: hideLoader,
                    error: function (xhr,status,error) {
                        firstXhrError(xhr);
                    }
                });
            }

            function validateForm($form) {
                $form.validate({
                    rules: {
                        code:               "required",
                        from:               "required",
                        to:                 "required",
                        subject:            "required",
                        body:               "required",
                    },
                    messages: {
                        code:               "Please provide Code",
                        from:               "Please provide From",
                        to:                 "Please provide To",
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

            function deleteDevice(id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('delete.email.template') }}',
                    dataType: 'json',
                    data:{id: id },
                    beforeSend: showLoader,
                    success: function (data) {
                        swal("Success!",'Email Template Deleted Sucessfully!' , "success");
                        loadEmailTemplateData();

                    },
                    complete: hideLoader,
                    error: function (xhr,status,error) {
                        firstXhrError(xhr);
                    }
                })

            }

            $('body').on('submit', '#add-email-template-form', function(e) {
                e.preventDefault();
                $form = $('#add-email-template-form');
                validateForm($form);
                if ($('#add-email-template-form').valid()) {
                    if(!$('#add-email-template-form #body').val()){
                        
                        $('#add-email-template-form .body').removeClass('display-none');
                    
                    }else{
                        
                        $('#add-email-template-form .body').addClass('display-none');
                            addEmailTemplate();
                    }
                }
            });

            function addEmailTemplate() {
                let formData = $('#add-email-template-form').serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('add.email.template') }}',
                    dataType: 'json',
                    data:formData,
                    beforeSend: showLoader,
                    success: function (data) {
                        swal("Success!",'Email Template Sucessfully Added!' , "success");
                        $('.close').click();
                        loadEmailTemplateData();   
                    },
                    complete: hideLoader,
                    error: function (xhr,status,error) {
                        firstXhrError(xhr);
                    }
                });
            }
        });
    </script>
@endpush
