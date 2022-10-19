@extends('layouts._app-auth')

@section('page-title')
    Staff
@endsection

@section('content')
<div class="subscbx bgwhite">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
                <h1><span><img src="{{ asset("theme/img/active_img.png") }}" width="11" height="11" alt=""/></span>All Staff</h1>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
                <div class="actionbtn"> 
                    <a class="btn markbtn createbtn" href="#createpopup" data-toggle="modal" data-target="#createpopup">Add New</a> 
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="sessionId" value={{ auth()->user()->id }} >
    <div class="subscribersdata">
        <div class="table-responsive">
            <table class="table audittable tablecentertxt" id="table">
                <thead>
                    <tr>
                        <th scope="col" class="custom-width">ID</th>
                        <th scope="col" class="custom-width">Company</th>
                        <th scope="col">Access Level</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                        <th scope="col" class="display-none"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="updateshipping" tabindex="-1" role="dialog" aria-labelledby="updateshipping" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close edit-model-close-btn" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                        <h1>Edit Staff</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="edit-staff-form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="" placeholder="">
                    <div class="row">
                        @include('Staff.partials._staffform', ['type' => ''])

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="createpopup" tabindex="-1" role="dialog" aria-labelledby="createpopup" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx">
                        <h1>Add New Staff</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="add-staff-form"  method="post" enctype="multipart/form-data">
                    <div class="row">

                        @include('Staff.partials._staffform', ['type' => 'create'])

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">Create Staff</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')

<script>
    $(function(){
        loadData();
        function loadData() {
            $('#table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('allstaff.datatable') }}",
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
                        "data": 'company_id',
                        'class' :'text-center',
                    },
                    { "data": 'level' },
                    { "data": 'fname' },
                    { "data": 'lname' },
                    { "data": 'email' },
                    { "data": 'action' },
                    { 
                        "data": 'all-data',
                        'class' :'display-none data-row',
                    },
                ]
                
            });
        }

        $('body').on('click', '.edit-btn', function() {
            let data = $(this).parents('tr').find('.data-row').text();
            setValue(data)
        })

        function setValue(data) {
            $('em').hide();
            data = JSON.parse(data);
            const $form = $('#edit-staff-form');
            $form.find('input').removeClass("is-invalid").val("");
            $form.find('#id').val(data.id);
            $form.find('#fname').val(data.fname);
            $form.find('#lname').val(data.lname);
            $form.find('#email').val(data.email);
            $form.find('#phone').val(data.phone);
            $form.find('#company_id').val(data.company_id);
            $form.find('#level').val(data.level);
        }

        $('body').on('submit', '#edit-staff-form', function(e) {
            e.preventDefault();
            const $form = $('#edit-staff-form');
            validateForm($form);
            if ($form.valid()) {
                createUpdateStuff($form);
            }
        });

        $('body').on('submit', '#add-staff-form', function(e) {
            e.preventDefault();
            const $form = $('#add-staff-form');
            validateAddForm($form);
            if ($form.valid()) {
                createUpdateStuff($form);
            }
        });

        $('body').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id');
            if($('#sessionId').val() == id){
                swal("Admin Logged in", "We are Sorry but Logged in Admin can't be Deleted", "error");
            }else{
                swal({
                    title: "Are you sure?",
                    text: "Do You really want to delete this Admin",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        deleteStuff(id);
                    }
                });
            }
        })

        function validateAddForm($form) {
            $form.validate({
                rules: {
                    fname: {
                        required:  true,  
                    },
                    lname: {
                        required:  true,
                    },
                    email:{
                        required:  true,
                        email:     true,
                        remote :{
                            url: "{{ route('check.staff.email') }}",
                            data: {id:  function () {
                                return $("#edit-staff-form").find('#id').val();
                                }
                            },
                            type: "post"
                        }
                    },
                    phone: {
                        required:   true,
                        number:     true,
                    },
                    password: {
                        required:   true,
                        minlength:  6,
                    },
                    password_confirmation: {
                        required:   true,
                        equalTo:  '#createpassword'
                    },
                },
                messages: {
                    fname:                 "Please provide First Name.",
                    lname:                 "Please provide Last Name.",
                    password:{
                        required:          "Please provide Password",
                        minlength:         "Your password must be atleast 6-characters long"
                    },
                    email: {
                        required:          "Please enter your email address",
                        email:             "Please enter a valid email address",
                        remote:            "Email Already exist"
                    },                
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
        }

        function validateForm($form) {
            $form.validate({
                rules: {
                    fname: {
                        required:  true,  
                    },
                    lname: {
                        required:  true,
                    },
                    email:{
                        required:  true,
                        email:     true,
                        remote :{
                            url: "{{ route('check.staff.email') }}",
                            data: {id:  function () {
                                return $("#edit-staff-form").find('#id').val();
                                }
                            },
                            type: "post"
                        }
                    },
                    phone: {
                        required:   true,
                        number:     true,
                    },
                    password: {
                        minlength:  6,
                    },
                    password_confirmation: {
                        equalTo:  '#password'
                    },
                },
                messages: {
                    fname:                 "Please provide First Name.",
                    lname:                 "Please provide Last Name.",
                    password:{
                        required:          "Please provide Password",
                        minlength:         "Your password must be atleast 6-characters long"
                    },
                    email: {
                        required:          "Please enter your email address",
                        email:             "Please enter a valid email address",
                        remote:            "Email Already exist"
                    },                
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
        }

        function createUpdateStuff($form) {
            let formData = $form.serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('create.update.stuff') }}",
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $('.close').click();
                    loadData();
                    swal("Success!",' ' , "success");
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        function deleteStuff(id) {
            $.ajax({
                type: 'POST',
                url: "{{ route('delete.stuff') }}",
                dataType: 'json',
                data:{ id: id},
                beforeSend: showLoader,
                success: function (data) {
                    loadData();
                    swal("Success!",'Admin Deleted Successfully' , "success");
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