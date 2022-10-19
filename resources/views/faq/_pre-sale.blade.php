<div class="tab-pane active" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
    <div class="subscbx bc">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 support">
                    <h1><span>
                            <img src='{{ asset("theme/img/icon_acti.png") }}' width="11" height="11" alt=""/>
                        </span>
                        <span id="title"></span>
                        <span>
                            <a href="#editCategory" class="editbtn editcatbtn" data-toggle="modal" data-target="#editCategory" id="editcatbtn"><span class="fas fa-pencil-alt"></span></a>
                            <a href="#deleteCategory" class="editbtn delete-cat-btn" data-toggle="modal" data-target="#deleteCategory" id="deletecatbtn"><span class="fas fa-trash-alt"></span></a>
                        </span>
                    </h1>
                    <br />
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <div class="actionbtn"> 
                        <a class="btn markbtn createbtn" href="#createfaq" data-toggle="modal" data-target="#createfaq">Create New Question</a> 
                    </div>
                </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable tablecentertxt" id="faq-table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col" style="width: 30px;">ID</th>
                            <th scope="col">Question</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="editCategory" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close edit-model-close-btn" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                    <h1>Edit Category</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id="edit-cat-form" method="post">
                    <input type="hidden" class="categoryId" name="id" value="">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                            <label for ="question">Name<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <input type="text" name="name" id="categoryname" class="" placeholder="" value="">
                            <p id="notes-error" class="error card-error description-error display-none">Please provide Description</p>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2" aria-hidden="true">UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="createfaq" tabindex="-1" role="dialog" aria-labelledby="createfaq" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close create-model-close-btn" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                    <h1>Create Question</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
            <form id="create-faq-form" method="post">
                <input type="hidden" class="categoryId" name="category_id" vlaue="">
                <div class="row">
                    <div class="form-group col-sm-12 col-md-12">
                            <label for ="question">Question<span class="text-danger"> *</span></label>
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <input type="text" name="question" id="question" class="form-control effect-1" placeholder="">
                        <span class="focus-border"></span>
                        <p id="notes-error" class="error card-error description-error display-none">Please provide Question</p>
                    </div>

                    <div class="form-group col-sm-12 col-md-12">
                        <label for= "description">Description<span class="text-danger"> *</span></label>
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <textarea name="description" id="description1">
                        </textarea>
                        <p id="notes-error" class="error card-error description-error display-none">Please provide Description</p>
                    </div>
                    <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                        <button type="submit" class="btn lightbtn2" aria-hidden="true">CREATE</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="editfaq" tabindex="-1" role="dialog" aria-labelledby="editfaq" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close edit-model-close-btn" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                    <h1>Edit Question</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
            <form id="edit-faq-form" method="post">
                <input type="hidden" name="id" id="id" value="" placeholder="">
                <div class="row">
                    <div class="form-group col-sm-12 col-md-12">
                            <label for ="question">Question<span class="text-danger"> *</span></label>
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <input type="text" name="question" id="question" class="form-control effect-1" placeholder="">
                        <span class="focus-border"></span>
                        <p id="notes-error" class="error card-error description-error display-none">Please provide Question</p>
                    </div>

                    <div class="form-group col-sm-12 col-md-12">
                        <label for= "description">Description<span class="text-danger"> *</span></label>
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <textarea name="description" id="description">
                        </textarea>
                        <p id="notes-error" class="error card-error description-error display-none">Please provide Description</p>
                    </div>
                    <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                        <button type="submit" class="btn lightbtn2" aria-hidden="true">UPDATE</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.ckeditor.com/ckeditor5/12.1.0/classic/ckeditor.js"></script>
<script>
    $(function(){

        $(".faq-tab-btn").on("click", function() {
            var categoryId = $(this).attr('data-id');
            $('.categoryId').val(categoryId);
            loadSupportData(categoryId);
            changeTableTitle(categoryId);
        });

        $( '.modal' ).modal( {
            focus: false,
            show: false
        } );

        function changeTableTitle(id) {
            @foreach($categories as $category)
                if({{$category->id}} == id) {
                    $('#title').text('{{$category->name}}');
                    $('#categoryname').val('{{$category->name}}');
                    $('.categoryId').val('{{$category->id}}'); 
                    $('#deletecatbtn').attr('data-id', '{{$category->id}}');
                }
            @endforeach
        }

        function loadSupportData(categoryId) {
            $('#faq-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{ route('support.show', 'insert_category_id') }}".replace('insert_category_id', categoryId),
                    beforeSend: showLoader,
                    complete: hideLoader,
                },
                "language": {
                    "processing": "Please Wait...",
                },
                "columns": [
                    { "data": 'first',
                      "orderable": false,
                    },
                    { 
                        "data": 'id',
                        'class' :'text-center',
                    },
                    { "data": 'question' },
                    { "data": 'description' },
                    {   
                        "data": 'action',
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

        $toolbar = [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ];

        $('body').on('click', '.edit-btn', function(e) {
            e.preventDefault();
            let data = $(this).parents('tr').find('.data-row').text();
            setValue(data);
        });

        $('body').on('click', '.createbtn', function(e) {
            e.preventDefault();
            setCreateValue();            
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

        $('body').on('submit', '#create-faq-form', function(e) {
            e.preventDefault();
            const form = $('#create-faq-form');
            validateForm(form);
            if ($('#create-faq-form').valid()) {
                if(!$('#description1').val()){
                    $('.description-error').removeClass('display-none');
                }else{
                    $('.description-error').addClass('display-none');
                        createProduct();
                }
            }
        });

        $('body').on('submit', '#edit-faq-form', function(e) {
            e.preventDefault();
            const $form = $('#edit-faq-form');
            validateForm($form);
            if ($('#edit-faq-form').valid()) {
                if(!$('#description').val()){
                    $('.description-error').removeClass('display-none');
                }else{
                    $('.description-error').addClass('display-none');
                        editProduct();
                }
            }
        });

        $('body').on('click', '.delete-cat-btn', function(e) {
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Do You really want to delete this Category",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    deleteCategory($(this).attr('data-id')) 
                }
            });
        });

        $('body').on('submit', '#create-cat-form', function(e) {
            e.preventDefault();
            const $form = $('#create-cat-form');
            validateCatForm($form);
            if ($('#create-cat-form').valid()) {
                createCategory();
            }
        });

        $('body').on('submit', '#edit-cat-form', function(e) {
            e.preventDefault();
            const $form = $('#edit-cat-form');
            validateCatForm($form);
            if ($('#edit-cat-form').valid()) {
                editCategory();
            }
        });

        function setCreateValue() {
            $('.ck-editor').empty();
            ClassicEditor
                .create( document.querySelector( '#description1' ),{
                    toolbar: $toolbar,
                } )
                .catch( error => {
                    console.error( error );
                } );
        }

        function resetCreateForm() {
            const $form = $('#create-faq-form');
            $form.find('#question').val('');
            $form.find('#id').val('');

        }
        
        function setValue(data) {
            data = JSON.parse(data);
            const $form = $('#edit-faq-form');
            $('.ck-editor').empty();
            $form.find('#question').val(data.question);
            $form.find('#id').val(data.id);
            $form.find('#description').val(data.description);
            ClassicEditor
                .create( document.querySelector( '#description' ),{
                    toolbar: $toolbar,
                } )
                .catch( error => {
                    console.error( error );
                } );
        }

        function validateForm($form) {
            $form.validate({
                rules: {
                    question: {
                      required: true
                    },
                },
                messages: {
                    question:  "Please Enter Question"
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

        function validateCatForm($form) {
            $form.validate({
                rules: {
                    name: {
                      required: true
                    },
                },
                messages: {
                    name:  "Please Enter Category Name"
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

        function createProduct() {
            let formData = $('#create-faq-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('support.store') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                        swal("Success!",'FAQ Sucessfully Created' , "success");
                        $('.create-model-close-btn').click().click();
                        resetCreateForm();
                        loadSupportData(data.category_id);

                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }        

        function editProduct() {
            let formData = $('#edit-faq-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('support.update') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                        swal("Success!",'FAQ Sucessfully Edited!' , "success");
                        $('.edit-model-close-btn').click().click();
                        loadSupportData(data.category_id);
                        
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        function createCategory() {
            let formData = $('#create-cat-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('category.create') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                        $('.create-model-close-btn').click().click();
                        swal("Success!",'Category Sucessfully Created!' , "success").then(function(){
                                location.reload();
                            });
                        
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        function editCategory() {
            let formData = $('#edit-cat-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('category.update') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                        $('.edit-model-close-btn').click().click();
                        swal("Success!",'Category Sucessfully Edited!' , "success").then(function(){
                                location.reload();  
                            });
                        
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
                url: '{{ route('support.delete') }}',
                dataType: 'json',
                data:{id: id },
                beforeSend: showLoader,
                success: function (data) {
                    swal("Success!",'FAQ Deleted Sucessfully!' , "success");
                    loadSupportData(data);
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            })
        }

        function deleteCategory(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('category.delete') }}',
                dataType: 'json',
                data:{id: id },
                beforeSend: showLoader,
                success: function (data) {
                    swal("Success!",'Category Deleted Sucessfully!' , "success");
                    location.reload();
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            })
        }
        
    });
    
</script>

@endpush