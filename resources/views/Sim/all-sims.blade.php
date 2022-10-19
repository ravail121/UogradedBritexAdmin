@extends('layouts._app-auth')

@section('page-title')
    Sims
@endsection

@section('content')
<div class="subscbx bgwhite">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
                <h1><span><img src="{{ asset("theme/img/active_img.png") }}" width="11" height="11" alt=""/></span>All SIM</h1>
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
                        <th scope="col">Carrier</th>
                        <th scope="col">Name</th>
                        <th scope="col">Standalone Price</th>
                        <th scope="col">Price with Plan</th>
                        <th scope="col" class="c-w-10">Shipping Fee</th>
                        <th scope="col">SKU</th>
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
                        <h1>Edit SIM</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="edit-product-form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="" placeholder="">
                    <div class="row">
                        @include('Sim.partials._simform', ['type' => ''])

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
                    <div class="topbx">
                        <h1>Add New SIM</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="add-product-form"  method="post" enctype="multipart/form-data">
                    <div class="row">

                        @include('Sim.partials._simform', ['type' => 'create'])

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">CREATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="product-image" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <div class="modal-body">
            <img class="model-product-image" src="">
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
        loadSimData();
        $( '.modal' ).modal( {
            focus: false,
            show: false
        } );
        $toolbar = [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'undo' ]

        function loadSimData() {
            $('#all-paln-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('allsim.datatable') }}",
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
                        "data": 'carrier',
                        'class' :'text-center',
                    },
                    { "data": 'name' },
                    { "data": 'stand-alone-price' },
                    { "data": 'price-with-plan' },
                    { "data": 'shipping-fee' },
                    { "data": 'sku' },
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

        $('body').on('click', '.product-image', function(e) {
            e.preventDefault();
            $('.model-product-image').attr('src', $(this).attr('src'));
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
            $form = $('#edit-product-form');
            validateForm($form);
            if ($form.valid()) {
                editProduct();
            }
        });

        function setValue(data) {
            data = JSON.parse(data);
            const $form = $('#edit-product-form');
            $('#edit-product-form .ck-editor').empty();
            $form.find('em').hide();
            $form.find('.is-invalid').removeClass('is-invalid'); 
            $form.find('#image').val(''); 
            $form.find('#id').val(data.id);
            $form.find('#name').val(data.name);
            $form.find('#sku').val(data.sku);
            $form.find('#carrier_id').val(data.carrier_id);
            $form.find('#description').val(data.description);
            $form.find('#amount_alone').val(data.amount_alone);
            $form.find('#notes').val(data.notes);
            $form.find('#show').val(data.show);
            $form.find('#amount_w_plan').val(data.amount_w_plan);
            $form.find('#shipping_fee').val(data.shipping_fee);
            $form.find('#code').val(data.code);
            $('#taxable').prop('checked', data.taxable);
            if(data.image){
                image = '<img class="product-image" data-toggle="modal" data-target="#product-image" src='+data.image+'>';
            }else{
                image ="";
            }
            $form.find('.data-product-image').html(image);

            ClassicEditor
                .create( document.querySelector( '#edit-product-form #description' ),{
                    toolbar: $toolbar,
                } )
                .catch( error => {
                    console.error( error );
                } );
        }

        function validateForm($form) {
            $form.validate({
                rules: {
                    amount_alone: {
                      required:     true,
                      number:       true 
                    },
                    amount_w_plan: {
                      required:     true,
                      number:       true 
                    },
                    shipping_fee: {
                      required:     true,
                      number:       true 
                    },
                    name:               "required",
                    carrier_id:         "required",
                },
                messages: {
                    amount_alone: {
                        required:      "Please enter Amount",
                        number:        "Amount field can only have numeric value"
                    },
                    amount_w_plan: {
                        required:      "Please enter Amount",
                        number:        "Amount field can only have numeric value"
                    },
                    shipping_fee: {
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
                url: '{{ route('edit.sim') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $image = $('#edit-product-form').find('#image');
                    if($image.val()){
                        UploadImage(data.id, $image);
                    }else{
                        swal("Success!",'Sim Sucessfully Edited!' , "success");
                        $('.edit-model-close-btn').click();
                        loadSimData();   
                    }
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        function UploadImage(id, $image = null) {
            let fd = new FormData();
            let files = $image[0].files[0];
            fd.append('image',files);
            fd.append('id',id);
                $.ajax({
                url:"{{ route('upload.sim.image') }}",
                method:"POST",
                data: fd,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(data)
                {
                    swal("Success!",'Sim Details & Image added Sucessfully!' , "success");
                    $('.close').click();
                    loadSimData();
                },
                error: function (data) {
                    swal("Image Not Updated!", "Sorry Something went wrong Sim Image not Upload", "error");
                }
            })
        }

        function deleteProduct(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('delete.sim') }}',
                dataType: 'json',
                data:{id: id },
                beforeSend: showLoader,
                success: function (data) {
                    if(data.error){
                         swal(data.error);
                    }else{
                        swal("Success!",'Sim Deleted Sucessfully!' , "success");
                        loadSimData();
                    }
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            })
        }

        $('body').on('submit', '#add-product-form', function(e) {
            e.preventDefault();
            $form = $('#add-product-form');
            validateForm($form);
            if ($form.valid()) {
                addProduct();
            }
        });

        function addProduct() {
            let formData = $('#add-product-form').serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('create.sim') }}",
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $image = $('#add-product-form').find('#image');
                    if($image.val()){
                        UploadImage(data.id, $image);
                    }else{
                        swal("Success!",'Sim Sucessfully Added!' , "success");
                        $('.close').click();
                        loadSimData();   
                    }
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        ClassicEditor
                .create( document.querySelector( '#add-product-form #description' ),{
                    toolbar: $toolbar,
                } )
                .catch( error => {
                    console.error( error );
                } );

    });
        
</script>
@endpush