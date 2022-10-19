@extends('layouts._app-auth')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
@endpush

@section('page-title')
   Devices
@endsection

@section('content')
<div class="subscbx bgwhite">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
                <h1><span><img src="{{ asset("theme/img/active_img.png") }}" width="11" height="11" alt=""/></span>All Devices</h1>
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
                        <th scope="col" class="custom-name-width">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Standalone Price</th>
                        <th scope="col" class="c-w-10">Price with Plan</th>
                        <th scope="col">Shipping Fee</th>
                        <th scope="col">Live</th>
                        <th scope="col">Operating System</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Modify</th>
                        <th scope="col" class="display-none"></th>
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
                        <h1>Edit Device</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="edit-device-form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="" placeholder="">
                    <div class="row">
                        @include('Device.partials._deviceform', ['form' => ''])

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
                    <div class="topbx margin-bottom40">
                        <h1>Add New Device</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="add-product-form"  method="post" enctype="multipart/form-data">
                    <div class="row">

                        @include('Device.partials._deviceform', ['form' => 'create'])

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">CREATE</button>
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

<div class="modal fade" id="product-image" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="uploaded-device-image container">

            </div>
            <form id ="device-image" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="col-sm-12 col-xs-12 right-con dropzone">
                    <div id="dropzoneFile">
                        <div class="zone-wrap">
                            <div class="dz-message" data-dz-message>
                                <span>
                                    <h5>+ Drop Files Here</h5>
                                    <p>Upload a JPEG, JPG, PNG, PDF file</p>
                                    {!! Form::label('', 'Choose File', ['class' => 'btn lbl-file']) !!}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" class="newDeviceId" name="new_id" id="new_id" value="" placeholder="">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Done</button>
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

        loadDeviceData();
        $( '.modal' ).modal( {
            focus: false,
            show: false
        } );

        $('#add-product-form #description_detail').summernote({
                height: 500
            });

        $('#add-product-form #description').summernote({
            height: 200
        });

        let addtionalCarrier = new Bloodhound({
          datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          prefetch: "{{route('additional-carrier') }}"
        });
        addtionalCarrier.initialize();

        let addtional_carrier_input = $('.additional_carrier');
        addtional_carrier_input.tagsinput({
            itemValue: 'id',
            itemText: 'name',
            typeaheadjs: {
                name: 'addtionalCarrier',
                displayKey: 'name',
                source: addtionalCarrier.ttAdapter(),
            }
        });

        let device_to_plan = new Bloodhound({
          datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          prefetch: "{{ route('device-to-plan') }}"
        });
        device_to_plan.initialize();

        let device_to_plan_input = $('.device_to_plan');
        device_to_plan_input.tagsinput({
            itemValue: 'id',
            itemText: 'name',
            typeaheadjs: {
                name: 'device_to_plan',
                displayKey: 'name',
                source: device_to_plan.ttAdapter(),
            }
        });

        // let device_to_sim = new Bloodhound({
        //   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        //   queryTokenizer: Bloodhound.tokenizers.whitespace,
        //   prefetch: "{ route('device-to-sim') }}"
        // });
        // device_to_sim.initialize();

        // let device_to_sim_input = $('.device_to_sim');
        // device_to_sim_input.tagsinput({
        //     itemValue: 'id',
        //     itemText: 'name',
        //     typeaheadjs: {
        //         name: 'device_to_sim',
        //         displayKey: 'name',
        //         source: device_to_sim.ttAdapter(),
        //     }
        // });

        function deviceToSim(simId)
        {
            let simDrowdown = $('.device_to_sim');
                simDrowdown.html('');
                simDrowdown.append('<option value="0">All</option>')
                simDrowdown.val(0);
            $.ajax({
                url: "{{ route('device-to-sim') }}",
                method: 'get',
                success: function (response) {
                    for (let i = 0; i < response.length; i++) {
                        let selected = simId == response[i]['id'] ? 'selected' : false;
                        simDrowdown.append('<option '+selected+' value='+response[i]['id']+'>'+response[i]['name']+'</option>');
                    }
                }
            })

        }
        
        function loadDeviceData() {
            $('#all-paln-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500, 1000], [25, 50, 100, 250, 500, 1000]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('alldevice.datatable') }}",
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
                    { "data": 'type' },
                    { "data": 'stand-alone-price' },
                    { "data": 'price-with-plan' },
                    { "data": 'shipping-fee' },
                    { "data": 'live' },
                    { "data": 'os' },
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
                    { 
                        "data": 'device-image',
                        "orderable": false,
                        'class' :'display-none data-image',
                    },
                ]
            });
        }
            
        $('body').on('click', '.edit-btn', function(e) {
            e.preventDefault();
            let data  = $(this).parents('tr').find('.data-row').text(),
                simId = $(this).attr('data-sim_id');
            setValue(data);
            deviceToSim(simId);
        });

        $('body').on('click', '.device-image', function(e) {
            e.preventDefault();
            $('.model-device-image').attr('src', $(this).attr('src'));
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
                    deleteDevice($(this).attr('data-id')) 
                }
            });
        });

        function setValue(data) {
            data = JSON.parse(data);
            const $form = $('#edit-device-form');
            $form.find('em').hide();
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('#description').summernote('destroy');
            $form.find('#description_detail').summernote('destroy');
            $form.find('#primary_image').val(''); 
            $form.find('#id').val(data.id);
            $form.find('#name').val(data.name);
            $form.find('#associate_with_plan').val(data.associate_with_plan);
            $form.find('#sku').val(data.sku);
            $form.find('#type').val(data.type);
            $form.find('#tag_id').val(data.tag_id);
            $form.find('#carrier_id').val(data.carrier_id);
            $form.find('#description').val(data.description);
            $form.find('#description_detail').val(data.description_detail);
            $form.find('#amount').val(data.amount);
            $form.find('#notes').val(data.notes);
            $form.find('#amount_w_plan').val(data.amount_w_plan);
            $form.find('#os').val(data.os);
            $form.find('#shipping_fee').val(data.shipping_fee);
            $form.find('#sort').val(data.sort);
            $form.find('#show').val(data.show);
            $form.find('#weight').val(data.weight);
            $form.find('.device-image').attr('src', data.primary_image);
            
            if(data.primary_image){
                image = '<img class="product-image" data-toggle="modal" data-target="#device-image" src='+data.primary_image+'>';
            }else{
                image = "";
            }
            $form.find('.device-image').html(image); 

            $('#taxable').prop('checked', data.taxable);
            addtional_carrier_input.tagsinput('removeAll');
            data.addtional_carrier.forEach(function(element) {
                $('#edit-device-form #additional_carrier').tagsinput('add', element);
            });
            device_to_plan_input.tagsinput('removeAll');
            data.device_to_plan.forEach(function(element) {
                $('#edit-device-form #device_to_plan').tagsinput('add', element);
            });
            // device_to_sim_input.tagsinput('removeAll');
            // data.device_to_sim.forEach(function(element) {
            //     $('#edit-device-form #device_to_sim').tagsinput('add', element);
            // });
            let imageHtml ="<br>";
            data.device_image.forEach(function(element) {
                imageHtml += "<div class='main-uploaded-image'><div class='uploaded-image'><img class = 'image'  alt='phone' src="+element.source+
                "></div><br><a href='#' data-id ="+element.id+" class='red-delete-btn delete-image'> Delete</a></div>"
                // imageHtml += "<img class='device-image' data-toggle='modal' data-target='#device-image' src="+element.source+">"
            });

            $(".uploaded-device-image").html(imageHtml);

            $('#edit-device-form #description_detail').summernote({
                height: 500
            });

            $('#edit-device-form #description').summernote({
                height: 200
            });
        }

        function editDevice(mydropzone) {
            let formData = $('#edit-device-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('edit.device') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $('#new_id').val(data.id);
                    $image = $('#edit-device-form').find('#primary_image');

                    if($image.val()){
                        UploadImage(data.id, $image);
                    }else{
                        hideLoader();
                        swal("Success!", 'Device Successfully Edited!' , "success");
                        $('.edit-model-close-btn').click();
                        loadDeviceData();
                        mydropzone.processQueue();  
                    }
                },
                error: function (xhr,status,error) {
                    hideLoader();
                    firstXhrError(xhr);
                }
            });
        }
        
        $('#edit-device-form').validate({
            rules: {
                amount: {
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
                sort: {
                  number:       true 
                },
                name:               "required",
                show:               "required",
                type:               "required",
                carrier_id:         "required",
            },
            messages: {
                amount: {
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
                name:               "Please provide Name",
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

        $('body').on('click', '.delete-image', function(e) {
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Do You really want to Delete this Image",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    let $this = $(this);
                    deleteImage($(this).attr('data-id'), $this);
                }
            });
        });

        function UploadImage(id, $image = null) {
            let fd = new FormData();
            let files = $image[0].files[0];
            fd.append('primary_image',files);
            fd.append('id',id);
                $.ajax({
                url:"{{ route('upload.device.image') }}",
                method:"POST",
                data: fd,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                complete: hideLoader,
                success:function(data)
                {
                    swal("Success!",'Device Details Submitted & Image Successfully Uploaded!' , "success");
                    $('.close').click();
                    loadDeviceData();
                },
                error: function (data) {
                    swal("Image Not Updated!", "Sorry Something went wrong Device Image not Upload", "error");
                }
            })
        }

        function deleteDevice(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('delete.device') }}',
                dataType: 'json',
                data:{id: id },
                beforeSend: showLoader,
                success: function (data) {
                    if(data.error){
                         swal(data.error);
                    }else{
                        swal("Success!",'Device Image Deleted Successfully!' , "success");
                        loadDeviceData();
                    }
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            })
        }

        function deleteImage(id, $this) {
            $.ajax({
                type: 'POST',
                url: '{{ route('delete.image') }}',
                dataType: 'json',
                data:{id: id },
                beforeSend: showLoader,
                success: function (data) {
                    $this.parents('.main-uploaded-image').hide()
                    swal("Success!",'Image Deleted Successfully!' , "success");
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            })

        }

        function addDevice(mydropzone) {
            let formData = $('#add-product-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('add.device') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $('#new_id').val(data.id);
                    $image = $('#add-product-form').find('#primary_image');
                    if($image.val()){
                        UploadImage(data.id, $image);
                    }else{
                        hideLoader();
                        swal("Success!",'Device Successfully Added!' , "success");
                        $('.close').click();
                        loadDeviceData();   
                    } 
                    mydropzone.processQueue();
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    hideLoader();
                    firstXhrError(xhr);
                }
            });
        }

        $("div#dropzoneFile").dropzone({
            url: "{{ route('upload.multiple.image') }}",
            paramName: "file",
            maxFilesize: 10,
            parallelUploads: 15,
            uploadMultiple: true,
            dictDuplicateFile: "Duplicate Files Cannot Be Uploaded",
            preventDuplicates: false,
            addRemoveLinks: true,  // This adds delete link on every file upload
            dictRemoveFile : "<i class='fa fa-trash' aria-hidden='true'></i>",
            autoProcessQueue: false,  // This avoids in automatic ajax file upload
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            timeout: 180000,
            removedfile: function(file) { // currently not in use
               var name = file.name; 

                if (this.files.length === 0) {
                    $('.dz-message').show();
                }

                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            init: function(file) {
                mydropzone = this;

                $('body').on('click', '.createbtn', function(e) {
                    mydropzone.removeAllFiles( true );
                    $(".uploaded-device-image").html('');
                });

                $('body').on('submit', '#add-product-form', function(e) {
                    e.preventDefault();
                    $form = $('#add-product-form');
                    if ($form.valid()) {
                        addDevice(mydropzone);
                    }
                });

                $('body').on('submit', '#edit-device-form', function(e) {
                    e.preventDefault();
                    $form = $('#edit-device-form');
                    if ($form.valid()) {
                        editDevice(mydropzone);
                    }
                });

                this.on('sending', function(file, xhr, formData) {

                    var data = $('#device-image').serializeArray();
                    var token = "{{csrf_token()}}";
                    formData.append('newDeviceId', $('#new_id').val());
                    formData.append('_token', token);
                    $.each(data, function(key, input) {
                        formData.append(input.name, input.value);
                    });
                });

                mydropzone.on("complete", function(file) {
                    mydropzone.removeFile(file);
                });
               

                mydropzone.on("error", function(file, response) {
                    if ($('body').find('.verify-error').length == 0) {

                        $('body').append('<div class="verify-error"><div class="alert alert-danger alert-dismissible text-center" role="alert" style="position: fixed; top: 5%; left: 11px; width: 30%; text-align: left; z-index: 4;"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Max. file size allowed is 10 MB</div></div>');
                    }

                    $('body').on('click', '.close', function() {
                        $('.verify-error').remove();

                    });
                    $(file.previewElement).find('.dz-error-message').text('Sorry, something went wrong please try again later');
                });

                mydropzone.on("addedfile", function(file) {
                    var extention = file.name.split('.').pop();

                    $('.left-con').find('small').remove();
                    $('#dropzoneFile').find('.dz-file-preview').removeClass('dz-file-preview').addClass('dz-image-preview');

                    $('.dz-message').hide();
                    $('.dz-progress').hide();
                    file.previewElement.classList.add("dz-success");

                    // To remove duplicate Files
                    if (this.files.length) {
                        var _i, _len;
                        for (_i = 0, _len = this.files.length; _i < _len - 1; _i++) {

                            if(this.files[_i].name === file.name && this.files[_i].size === file.size && this.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString()) {
                                this.removeFile(file);
                            }
                        }
                    }

                });
            },
        });

        $('#add-product-form').validate({
            rules: {
                amount: {
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
                sort: {
                  number:       true 
                },
                name:               "required",
                show:               "required",
                type:               "required",
                carrier_id:         "required",
            },
            messages: {
                amount: {
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
                name:               "Please provide Name",
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

    });
</script>
@endpush