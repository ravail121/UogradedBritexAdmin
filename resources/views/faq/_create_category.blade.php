<div class="modal fade bd-example-modal-xl" id="createCategory" tabindex="-1" role="dialog" aria-labelledby="createCategory" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close create-model-close-btn" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                        <h1>Create Category</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id="create-cat-form" method="post">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12">
                            <label for ="question">Name<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            <input type="text" name="name" id="name" class="" placeholder="Category Name">
                            <p id="notes-error" class="error card-error description-error display-none">Please provide Category Name</p>
                        </div>
                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2" aria-hidden="true">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(function(){

            $('body').on('submit', '#create-cat-form', function(e) {
                e.preventDefault();
                const $form = $('#create-cat-form');
                validateCatForm($form);
                if ($('#create-cat-form').valid()) {
                    createCategory();
                }
            });

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
                    error: function (xhr, status, error) {
                        firstXhrError(xhr);
                    }
                });
            }
        });

    </script>

@endpush
