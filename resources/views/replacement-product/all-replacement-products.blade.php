@extends('layouts._app-auth')

@section('page-title')
    Replacement Products
@endsection

@section('content')
    <div class="subscbx bgwhite">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-10">
                    <h1><span><img src="{{ asset("theme/img/active_img.png") }}" width="11" height="11" alt="All Replacement Products"/></span>All Replacement Products</h1>
                </div>
                <div class="col-sm-12 col-md-2 col-lg-2">
                    <div class="actionbtn">
                        <a class="btn markbtn createbtn" href="#add-replacement-product-popup" data-toggle="modal" data-target="#add-replacement-product-popup">Add New</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable tablecentertxt" id="all-replacement-products-table">
                    <thead>
                    <tr>
                        <th scope="col" class="custom-width">ID</th>
                        <th scope="col">Type</th>
                        <th scope="col">Product</th>
                        <th scope="col">Modify</th>
                        <th scope="col" class="display-none"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="update-replacement-products-table" tabindex="-1" role="dialog" aria-labelledby="update-replacement-products-table" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content editpopcontent">
                <button type="button" class="close edit-model-close-btn" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="topbx purplebg" style="margin:0 0 40px 0;">
                            <h1>Edit Replacement Product</h1>
                        </div>
                    </div>
                </div>
                <div class="popvtmcont">
                    <form id ="replacement-product-edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="replacement-product-id" value="">
                        <div class="row">
                            @include('replacement-product.partials._replacement_product_form', ['form' => 'replacement-product-edit'])

                            <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                                <button type="submit" class="btn lightbtn2">UPDATE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="add-replacement-product-popup" tabindex="-1" role="dialog" aria-labelledby="add-replacement-product-popup" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content editpopcontent">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="topbx margin-bottom40">
                            <h1>Add New Replacement Product</h1>
                        </div>
                    </div>
                </div>
                <div class="popvtmcont">
                    <form id ="add-replacement-product-form"  method="post" enctype="multipart/form-data">
                        <div class="row">

                            @include('replacement-product.partials._replacement_product_form', ['form' => 'replacement-product-create'])

                            <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                                <button type="submit" class="btn lightbtn2">CREATE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script>
        $(function(){

            loadReplaceMentProductsData();
            $( '.modal' ).modal( {
                focus: false,
                show: false
            } );

            function loadReplaceMentProductsData() {
                $('#all-replacement-products-table').DataTable( {
                    "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                    "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "info": true,
                    "bDestroy": true,
                    "ajax": {
                        "url": "{{ url('all-replacement-products/datatables') }}",
                        beforeSend: showLoader,
                        complete: hideLoader,
                    },
                    "language": {
                        "processing": "Please Wait...",
                    },
                    "columns": [
                        {
                            "data": 'id',
                            'class':'text-center',
                        },
                        {
                            "data": 'type',
                            'class':'text-center',
                        },
                        {
                            "data": 'product',
                            'class':'text-center',
                        },
                        {
                            "data": 'modify',
                            "orderable": false,
                        },
                        {
                            "data": 'all-data',
                            "orderable": false,
                            'class' :'display-none data-row',
                        }
                    ]
                });
            }

            $('body').on('click', '.edit-btn', function(e) {
                e.preventDefault();
                var data  = $(this).parents('tr').find('.data-row').text();
                setValue(data);
            });


            $('body').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Do You really want to delete this product",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        deleteReplaceMentProduct($(this).attr('data-id'))
                    }
                });
            });

            function setValue(data) {
                data = JSON.parse(data);
                var $form = $('#replacement-product-edit');
                $form.find('em').hide();
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('#replacement-product-id').val(data.id);
                $form.find('#replacement-product-edit-type').val(data.product_type);
                if(data.product_type === 'sim'){
                    $('.replacement-product-edit-sim-product-wrapper').show();
                    $('.replacement-product-edit-device-product-wrapper').hide();
                    $(".replacement-product-edit-device-product-wrapper select").removeAttr('name');
                    $(".replacement-product-edit-sim-product-wrapper select").attr('name', 'product_id');
                } else {
                    $('.replacement-product-edit-sim-product-wrapper').hide();
                    $('.replacement-product-edit-device-product-wrapper').show();
                    $(".replacement-product-edit-sim-product-wrapper select").removeAttr('name');
                    $(".replacement-product-edit-device-product-wrapper select").attr('name', 'product_id');
                }
            }

            $('body').on('change', '#replacement-product-create-type', function(e) {
                if($(this).val() === 'sim'){
                    $('.replacement-product-create-sim-product-wrapper').show();
                    $('.replacement-product-create-device-product-wrapper').hide();
                    $(".replacement-product-create-device-product-wrapper select").removeAttr('name');
                    $(".replacement-product-create-sim-product-wrapper select").attr('name', 'product_id');
                } else {
                    $('.replacement-product-create-sim-product-wrapper').hide();
                    $('.replacement-product-create-device-product-wrapper').show();
                    $(".replacement-product-create-sim-product-wrapper select").removeAttr('name');
                    $(".replacement-product-create-device-product-wrapper select").attr('name', 'product_id');
                }
            });

            $('body').on('change', '#replacement-product-edit-type', function(e) {
                if($(this).val() === 'sim'){
                    $('.replacement-product-edit-sim-product-wrapper').show();
                    $('.replacement-product-edit-device-product-wrapper').hide();
                    $(".replacement-product-edit-device-product-wrapper select").removeAttr('name');
                    $(".replacement-product-edit-sim-product-wrapper select").attr('name', 'product_id');
                } else {
                    $('.replacement-product-edit-sim-product-wrapper').hide();
                    $('.replacement-product-edit-device-product-wrapper').show();
                    $(".replacement-product-edit-sim-product-wrapper select").removeAttr('name');
                    $(".replacement-product-edit-device-product-wrapper select").attr('name', 'product_id');
                }
            });

            function deleteReplaceMentProduct(id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('delete-replacement-product') }}',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    beforeSend: showLoader,
                    success: function (data) {
                        if(data.error){
                            swal(data.error);
                        }else{
                            swal("Success!", 'Replacement product deleted successfully!' , "success");
                            loadReplaceMentProductsData();
                        }
                    },
                    complete: hideLoader,
                    error: function (xhr, status, error) {
                        firstXhrError(xhr);
                    }
                })
            }

            function validateForm(){
                $('#add-replacement-product-form').validate({
                    rules: {
                        type: {
                            required:     true
                        },
                        product: {
                            required:     true,
                            number:       true
                        }
                    },
                    messages: {
                        type: {
                            required:      "Please select the product type"
                        },
                        product: {
                            required:      "Please select the product"
                        }
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

            function editReplacementProduct() {
                let formData = $('#replacement-product-edit').serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('edit-replacement-product') }}',
                    dataType: 'json',
                    data:formData,
                    beforeSend: showLoader,
                    success: function (data) {
                        hideLoader();
                        if(data.hasOwnProperty('status') && data.status === 'error'){
                            swal("Error!", data.message, 'error');
                        } else {
                            swal("Success!", 'Replacement product successfully edited!' , "success");
                            $('.close').click();
                            loadReplaceMentProductsData();
                        }
                    },
                    complete: hideLoader,
                    error: function (xhr, status, error) {
                        firstXhrError(xhr);
                    }
                });
            }

            $('body').on('submit', '#add-replacement-product-form', function(e) {
                e.preventDefault();
                var form = $('#add-replacement-product-form');
                validateForm(form);
                if (form.valid()) {
                    addReplacementProduct(form);
                }
            });

            function addReplacementProduct(form) {
                var formData = form.serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('add-replacement-product') }}',
                    dataType: 'json',
                    data:formData,
                    beforeSend: showLoader,
                    success: function (data) {
                        hideLoader();
                        if(data.hasOwnProperty('status') && data.status === 'error'){
                            swal("Error!", data.message, 'error');
                        } else {
                            swal("Success!",'Replacement product successfully added!' , "success");
                            $('.close').click();
                            loadReplaceMentProductsData();
                        }
                    },
                    complete: hideLoader,
                    error: function (xhr, status, error) {
                        hideLoader();
                        firstXhrError(xhr);
                    }
                });
            }

            $('body').on('submit', '#replacement-product-edit', function(e) {
                e.preventDefault();
                $form = $('#replacement-product-edit');
                validateForm($form);
                if ($form.valid()) {
                    editReplacementProduct();
                }
            });
        });
    </script>
@endpush