@extends('layouts._app-auth')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
@endpush

@section('page-title')
   Addons
@endsection

@section('content')
<div class="subscbx bgwhite">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
                <h1><span><img src="{{ asset("theme/img/active_img.png") }}" width="11" height="11" alt=""/></span>All Addons</h1>
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
            <table class="table audittable tablecentertxt" id="all-paln-table">
                <thead>
                    <tr>
                        <th scope="col" class="custom-width">ID</th>
                        <th scope="col" class="custom-name-width text-center">Name</th>
                        <th scope="col">Recurring Price</th>
                        <th scope="col">SKU</th>
                        <th scope="col">SOC Code</th>
                        <th scope="col" class="custom-name-width">Modify</th>
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
                        <h1>Edit Addons</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="edit-product-form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="" placeholder="">
                    <div class="row">
                        @include('Addon.partials._addonform', ['type' => ''])

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
                        <h1>Add New Addon</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="add-product-form"  method="post" enctype="multipart/form-data">
                    <div class="row">
                        @include('Addon.partials._addonform', ['type' => 'create'])

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">CREATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
<script>
    $(function(){
        loadAddonData();
        $( '.modal' ).modal( {
            focus: false,
            show: false
        } );

        $toolbar = [
            ['style', ['style']],
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['Misc', ['codeview']],
        ];

        $('#add-product-form #description').summernote({
            toolbar: $toolbar,
            height: 200
        });

        function loadAddonData() {
            $('#all-paln-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('alladdon.datatable') }}",
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
                        "data": 'name',
                        'class' :'text-center',
                    },
                    { "data": 'recurring-price' },
                    { "data": 'sku' },
                    { "data": 'soc-code' },
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
            setValue(data);
        });

        $('body').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Do You really want to delete this Product",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    deleteProduct($(this).attr('data-id')) 
                }
            });
        });

        $('body').on('submit', '#edit-product-form', function(e) {
            e.preventDefault();
            $form = $('#add-product-form');
            validateForm($form);
            if ($form.valid()) {
                if(!$('#edit-product-form #description').val()){
                    $('#edit-product-form .description-error').removeClass('display-none');
                }else{
                    $('#edit-product-form .description-error').addClass('display-none');
                        editProduct();
                }
            }
        });

        function setValue(data) {
            data = JSON.parse(data);
            const $form = $('#edit-product-form');
            $form.find('#description').summernote('destroy');
            $form.find('em').hide();
            $form.find('.is-invalid').removeClass('is-invalid'); 
            $form.find('#id').val(data.id);
            $form.find('#name').val(data.name);
            $form.find('#sku').val(data.sku);
            $form.find('#description').val(data.description);
            $form.find('#notes').val(data.notes);
            $form.find('#show').val(data.show);
            $form.find('#amount_recurring').val(data.amount_recurring);
            $form.find('#soc_code').val(data.soc_code);
            $form.find('#bot_code').val(data.bot_code);
            $('#taxable').prop('checked', data.taxable);

            $form.find('#description').summernote({
                toolbar: $toolbar,
                height: 200
            });
        }

        function validateForm($form) {
            $form.validate({
                rules: {
                    amount_recurring: {
                      required:     true,
                      number:       true 
                    },
                    name:               "required",
                    carrier_id:         "required",
                },
                messages: {
                    amount_recurring: {
                        required:      "Please enter Amount",
                        number:        "Amount field can only have numeric value"
                    },
                    name:               "Please provide Description",
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

        function editProduct() {
            let formData = $('#edit-product-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('edit.addon') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    swal("Success!",'Addon Sucessfully Edited!' , "success");
                        $('.edit-model-close-btn').click();
                        loadAddonData();
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }


        function deleteProduct(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('delete.addon') }}',
                dataType: 'json',
                data:{id: id },
                beforeSend: showLoader,
                success: function (data) {
                    if(data.error){
                         swal(data.error);
                    }else{
                        swal("Success!",'Addon Deleted Sucessfully!' , "success");
                        loadAddonData();
                    }
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            })
        }
        $('body').on('click', '.createbtn', function(e) {
            e.preventDefault();
        });

        $('body').on('submit', '#add-product-form', function(e) {
            e.preventDefault();
            $form = $('#add-product-form');
            validateForm($form);
            if ($form.valid()) {
                if($('#add-product-form #description').val().trim()== ""){
                    $('#add-product-form .description-error').removeClass('display-none');
                }else{
                    $('#add-product-form .description-error').addClass('display-none');
                        addProduct();
                }
            }
        });


        function addProduct() {
            let formData = $('#add-product-form').serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('create.addon') }}",
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    swal("Success!",'Addon Created Sucessfully!' , "success");
                        $('.close').click();
                        loadAddonData();
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