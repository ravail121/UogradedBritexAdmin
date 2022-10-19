<div class="container" id="SwapSims">
    <hr>
    <div class="table-padding">
        <h3>SWAP SIM Changes (Upload a CSV file to Change Multiple SIMS)</h3>
    </div>
    <form id="sim_change_csv" enctype="multipart/form-data">
        <input type="hidden" name="targetId" value="SwapSims">
        <div class="form-group">
            <input type="file" name="sim_change_csv_upload" id="sim_change_csv_upload" required><br>
            <label for="sim_change_csv_upload" class="form-label">Upload CSV file to Assign Sim Number (This endpoint assigns a new sim number to an activated line.)</label><br>
            <input type="submit" name="submit" value="Upload" class="btn btn-primary">
        </div>
    </form>
    <div class="result_swap_sims_upload">

    </div>
        <div class="form-group text-center">
            <hr> <strong>OR</strong>
            <hr>
        </div>

    <form id="sim_change" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-md-6 col-sm-6">
                <label for="phone_number1">Phone Number:</label>
                <input type="text" name="phone_number[]" placeholder="123-123-1234" class="form-control" id="phone_number1" required>
            </div>
            <div class="col-md-6 col-sm-6">
                <label for="sim_number1">SIM Number:</label>
                <input type="text" name="sim_number[]" class="form-control" id="sim_number1" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6 col-sm-6">
                <label for="phone_number2">Phone Number:</label>
                <input type="text" name="phone_number[]" placeholder="123-123-1234" class="form-control" id="phone_number2">
            </div>
            <div class="col-md-6 col-sm-6">
                <label for="sim_number2">SIM Number:</label>
                <input type="text" name="sim_number[]" class="form-control" id="sim_number2">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6 col-sm-6">
                <label for="phone_number3">Phone Number:</label>
                <input type="text" name="phone_number[]" placeholder="123-123-1234" class="form-control" id="phone_number3">
            </div>
            <div class="col-md-6 col-sm-6">
                <label for="sim_number3">SIM Number:</label>
                <input type="text" name="sim_number[]" class="form-control" id="sim_number3">
            </div>
        </div>

        <div class="form-group">
            <p>
                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
            </p>
        </div>
    </form>

    <div class="result_swap_sims">
    </div>
</div>

@push('js')
<script>
$(function(){
    $('#sim_change').validate({
        rules: {
            phone_number1:  "required",
        },
        messages: {
            phone_number1:  "Please provide Description",
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


    $('#sim_change').on('submit', function (e) {
        e.preventDefault();
        if($('#sim_change').valid()){
            submitChangeSimRequest();
        }
    });

    $('#sim_change_csv').on('submit', function (e) {
        e.preventDefault();
        changeSimCsv();
    });


    function submitChangeSimRequest(){
        $.ajax({
            type: 'POST',
            url: '{{ route('goknow.change.sim') }}',
            data:$('#sim_change').serialize(),
            beforeSend: showLoader,
            success: function (data) {
                $('.result_swap_sims').html('<p class="response">'+data+'</p>');
            },
            complete: hideLoader,
            error: function (xhr,status,error) {
                firstXhrError(xhr);
            }
        });
    }

    function changeSimCsv() {
        let fd = new FormData();
        $csv = $('#sim_change_csv_upload');
        let files = $csv[0].files[0];
        fd.append('csv_file',files);
        fd.append('type', 'changesim');
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
                $('.result_swap_sims_upload').html('<p class="response">'+data+'</p>');
            },
            error: function (xhr,status,error) {
                firstXhrError(xhr);
            }
        })
    }
});

</script>
@endpush