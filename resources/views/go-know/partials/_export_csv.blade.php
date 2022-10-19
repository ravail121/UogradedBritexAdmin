<div class="container">
    <hr>
    <div class="table-padding">
        <h3>Export Reports in CSV</h3>
    </div>

    <div class="result_activate_lines">

        <form action="{{ route('goknow.csv.report') }}" method="POST" id="CsvReportForm">

            <div class="form-group">
                <select name="reports_in_csv" class="form-control reports_in_csv" id ="reports_in_csv" required="">
                    <option value="">Please Select Report type</option>
                    <option value="all">All Phone Numbers</option>
                    <option value="specific_numbers">Specific Phone Numbers</option>
                    <option value="specific_sims">Specific Sims</option>
                </select>

            </div>

            <div class="form-group specific_numbers_form_field csv-text-option display-none">
                <textarea name="specific_numbers" class="form-control" rows="8" placeholder="Specific Numbers 1 per line, eg: 123-456-7891"></textarea>
            </div>
            <div class="form-group specific_sims_form_field csv-text-option display-none">
                <textarea name="specific_sims" class="form-control" rows="8" placeholder="Specific Sims 1 per line"></textarea>
            </div>
            <div class="form-group">
                <p>
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                </p>
            </div>
        </form>

    </div>

</div>

@push('js')
<script>
    $(function(){
        $('#reports_in_csv').on('change', showTextbox);

        function showTextbox() {
            $(".csv-text-option").addClass('display-none');
            if($('#reports_in_csv').val() == 'specific_numbers'){
                $(".specific_numbers_form_field").removeClass('display-none');
            }else if($('#reports_in_csv').val() == 'specific_sims'){
                $(".specific_sims_form_field").removeClass('display-none');
            }
        }
        hideLoader();
    });
</script>
@endpush