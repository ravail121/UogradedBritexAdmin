<div class="container" id="areaCodeChange">

    <hr>
    <div class="table-padding">
        <h3>Areacode Changes</h3>
    </div>

    <form id ="areacode_csv" enctype="multipart/form-data">
        <div class="form-group">
            <input type="file" name="csv_upload_areacode" id="csv_upload_areacode" required ><br>
            <label class="form-label" for="csv_upload_areacode">Upload CSV File to change Area code of SIMS (This endpoint assigns a new phone numbers to an activated lines.)</label><br>
            <input type="submit" name="submit" value="Upload" class="btn btn-primary">
        </div>
    </form>
    <div class="result_areacode_change_upload">

    </div>
        <div class="form-group text-center">
            <hr> <strong>OR</strong>
            <hr>
        </div>

    <form id ="areacode" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-md-6 col-sm-6">
                <label for="areacode1">Phone Number:</label>
                <input type="text" name="area_phone_number[]" placeholder="123-123-1234" class="form-control" id="area_phone_number1" required="">
            </div>
            <div class="col-md-6 col-sm-6">
                <label for="area_code1">Area Code:</label>
                <input type="text" name="areacode[]" placeholder="404" class="form-control" id="area_code1" required="">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6 col-sm-6">
                <label for="areacode2">Phone Number:</label>
                <input type="text" name="area_phone_number[]" placeholder="123-123-1234" class="form-control" id="areacode2">
            </div>
            <div class="col-md-6 col-sm-6">
                <label for="area_code2">Area Code:</label>
                <input type="text" name="areacode[]" placeholder="404" class="form-control" id="area_code2">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6 col-sm-6">
                <label for="areacode3">Phone Number:</label>
                <input type="text" name="area_phone_number[]" placeholder="123-123-1234" class="form-control" id="areacode3">
            </div>
            <div class="col-md-6 col-sm-6">
                <label for="area_code3">Area Code:</label>
                <input type="text" name="areacode[]" placeholder="404" class="form-control" id="area_code3">
            </div>
        </div>
        <div class="form-group">
            <p>
                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
            </p>
        </div>

    </form>

    <div class="result_areacode_change">

    </div>
</div>

@push('js')
<script>
$(function(){

    $('#areacode').validate({
        rules: {
            area_phone_number1:  "required",
        },
        messages: {
            area_phone_number1:  "Please provide Phone Number",
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
    
    $('#areacode').on('submit', function (e) {
        e.preventDefault();
        if($('#areacode').valid()){
            submitChangeAreaCodeRequest();
        }
    });

    $('#areacode_csv').on('submit', function (e) {
        e.preventDefault();
        areaCodeCsv();
    });

    function submitChangeAreaCodeRequest(){
        $.ajax({
            type: 'POST',
            url: '{{ route('goknow.change.areacode') }}',
            data:$('#areacode').serialize(),
            beforeSend: showLoader,
            success: function (data) {
                $('.result_areacode_change').html('<p class="response">'+data+'</p>');
            },
            complete: hideLoader,
            error: function (xhr,status,error) {
                firstXhrError(xhr);
            }
        });
    }

    function areaCodeCsv() {
        let fd = new FormData();
        $csv = $('#csv_upload_areacode');
        let files = $csv[0].files[0];
        fd.append('csv_file',files);
        fd.append('type', 'areacode');
            $.ajax({
            url:"{{ route('goknow.change.areacode.csv') }}",
            method:"POST",
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: showLoader,
            complete: hideLoader,
            success:function(data)
            {
                $('.result_areacode_change_upload').html('<p class="response">'+data+'</p>');
            },
            error: function (xhr,status,error) {
                firstXhrError(xhr);
            }
        })
    }
});
</script>
@endpush