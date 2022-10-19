<div class="container" id="restoreLines">
    <div class="table-padding">
        <h3>Restore Multiple lines</h3>
    </div>
    <div class="Restore_line_form">

        <form id="restore_lines">
            <input type="hidden" name="target_status" value="restoreLines">
            <div class="form-group">
                <textarea class="form-control" name="phone_number" rows="5" cols="50" placeholder="1 number per line, eg: 123-456-7891" id ="restore_phone_number" required=""></textarea>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
            </div>

        </form>
    </div>

    <div class="result_restore_line">
    </div>
    
</div>

@push('js')
<script>
$(function(){
    $('#restore_lines').validate({
        rules: {
            restore_phone_number:  "required",
        },
        messages: {
            restore_phone_number:  "Please provide Description",
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


    $('#restore_lines').on('submit', function (e) {
        e.preventDefault();
        if($('#restore_lines').valid()){
            submitRestoreLineRequest();
        }
    });

    function submitRestoreLineRequest(){
        $.ajax({
            type: 'POST',
            url: '{{ route('get.goknow.restore.response') }}',
            data:$('#restore_lines').serialize(),
            beforeSend: showLoader,
            success: function (data) {
                $('.result_restore_line').html('<p class="response">'+data+'</p>');
            },
            complete: hideLoader,
            error: function (data) {
                firstXhrError(xhr);
            }
        });
    }
});
</script>
@endpush