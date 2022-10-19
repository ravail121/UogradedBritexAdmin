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
   Canned Response
@endsection

@section('content')
<div class="subscbx bgwhite">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
                <h1><span><img src="{{ asset('theme/img/active_img.png') }}" width="11" height="11" alt=""/></span>Canned Response</h1>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
                <div class="actionbtn"> 
                    <a class="btn markbtn createbtn" href="#createpopup" data-toggle="modal" data-target="#createpopup">Add New</a> 
                </div>
            </div>
        </div>
    </div>
    <div class="subscribersdata">
        <div class="table-responsive">
            <table class="table audittable tablecentertxt" id="table">
                <thead>
                    <tr>
                        <th scope="col" class="custom-width">ID</th>
                        <th scope="col" >Section</th>
                        <th scope="col">Name</th>
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
                <form id ="edit-canned-response" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="" placeholder="">
                    <div class="row">
                        @include('email-template.partials._cannedresponseform', ['form' => ''])

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

                        @include('email-template.partials._cannedresponseform', ['form' => 'create'])

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
            loadCannedResponseData();

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

            function loadCannedResponseData() {
                $('#table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{ URL::route('cannded.response.datatable') }}",
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
                        "data": 'section',
                        "class": 'text-center'
                    },
                    { "data": 'name' },
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
                setValue(data);
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
                const $form = $('#edit-canned-response');
                $form.find('.ck-editor').empty(); 
                $form.find('#id').val(data.id);
                $form.find('#section').val(data.section);
                $form.find('#name').val(data.name);
                $form.find('#subject').val(data.subject);
                $form.find('#body').val(data.body);
                updateSection(data.section);

                $toolbar = [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList' ]

                ClassicEditor.create( document.querySelector( '#edit-canned-response #body' ),{
                    toolbar: $toolbar,
                } )
                .catch( error => {
                    console.error( error );
                } );
            }

            $('body').on('submit', '#edit-canned-response', function(e) {
                e.preventDefault();
                $form = $('#edit-canned-response');
                validateForm($form);
                if ($('#edit-canned-response').valid()) {
                    if(!$('#body').val()){
                        $('.body-error').removeClass('display-none');
                    }else{
                        $('.body-error').addClass('display-none');
                        editEmailTemplate();            
                    }
                }
            });


            function editEmailTemplate() {
                let formData = $('#edit-canned-response').serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('edit.canned.response') }}',
                    dataType: 'json',
                    data:formData,
                    beforeSend: showLoader,
                    success: function (data) {
                        swal("Success!",'Email Template Sucessfully Edited!' , "success");
                        $('.edit-model-close-btn').click();
                        loadCannedResponseData();   
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
                        name:               "required",
                        section:            "required",
                        subject:            "required",
                        body:               "required",
                    },
                    messages: {
                        name:               "Please provide Name",
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

            $('#createsection, #section').change(function() {
                updateSection($(this).val());
            })

            // $('#add-email-template-form #createsection').change(function() {
            //     updateSection($('#createsection').val());
            // })

            function updateSection(section){
                $('.place-holderdata').addClass('display-none');
                if(section == 1){
                    $('.business').removeClass('display-none')
                }else{
                    $('.customer').removeClass('display-none')
                }
            }

            function deleteDevice(id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('delete.canned.response') }}',
                    dataType: 'json',
                    data:{id: id },
                    beforeSend: showLoader,
                    success: function (data) {
                        swal("Success!",'Email Template Deleted Sucessfully!' , "success");
                        loadCannedResponseData();

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
                    url: '{{ route('add.canned.response') }}',
                    dataType: 'json',
                    data:formData,
                    beforeSend: showLoader,
                    success: function (data) {
                        swal("Success!",'Email Template Sucessfully Added!' , "success");
                        $('.close').click();
                        loadCannedResponseData();   
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
