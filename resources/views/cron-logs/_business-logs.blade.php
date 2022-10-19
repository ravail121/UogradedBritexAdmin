@push('js')
<script>

    $(function(){

        $('#business-tab').click(function() {

            $('#title').html('Business Verification'+'<hr>');

            $('#display').html('');

            $('.cron-logs-display').addClass('display-none');

            $.ajax({
                url:'{{ route("cron.get-logs") }}',
                method:'GET',
                dataType:'json'

            }).done(function(response) {
               
                if (response['business'].length === 0) {
                    $('#display').append('No logs today');
                }
                var count = 1;
                for (let i = 0; i < response['business'].length; i++) {
                    var business = response['business'][i];
                    $('#display').append(
                        count + ' - New business added with name </strong>"' + business['business_name'] + '"</strong></br>'
                    );
                    count++;
                }
            });

        });

    });
    
</script>
@endpush
    