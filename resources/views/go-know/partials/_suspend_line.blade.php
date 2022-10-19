<div class="container" id="suspendLines">
    <hr>
    <div class="table-padding">
        <h3>Suspend Multiple lines</h3>
    </div>

    <div class="suspendmultiplelines">
        <form id = "suspend_lines">
            <input type="hidden" name="target_status" value="suspendLines">

            <div class="form-group">
                <textarea name="phone_number" class="form-control" rows="5" cols="50" placeholder="1 number per line, eg: 123-456-7891"  id ="suspende_phone_number" required=""></textarea>
            </div>
            <div class="form-group">
                <p>
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                </p>
            </div>

        </form>
    </div>

    <div class="result_suspend_lines">
    </div>
    
</div>

@push('js')
<script>
$(function(){
    $('#suspend_lines').validate({
        rules: {
            suspende_phone_number: "required",
        },
        messages: {
            suspende_phone_number: "Please provide Description",
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

    $('#suspend_lines').on('submit', function (e) {
        e.preventDefault();
        if($('#suspend_lines').valid()){
            submitSuspendedLineRequest();
        }
    });


    function submitSuspendedLineRequest(){
        $.ajax({
            type: 'POST',
            url: '{{ route('get.goknow.response') }}',
            data:$('#suspend_lines').serialize(),
            beforeSend: showLoader,
            success: function (data) {
                $('.result_suspend_lines').html('<p class="response">'+data+'</p>');
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