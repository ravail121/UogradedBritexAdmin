@push('js')
<script>
    
    $(function(){

        $('#subscription-tab').click(function() {

            $('#title').html('Subscription Logs'+'<hr>');

            $('#display').html('');

            $('.cron-logs-display').addClass('display-none');

            $.ajax({
                url:'{{ route("cron.get-logs") }}',
                method:'GET',
                dataType:'json'

            }).done(function(response) {

                if (response['subscription'].length === 0) {
                    $('#display').append('No logs today');
                }

                var count = 1;
                for (let i = 0; i < response['subscription'].length; i++) {
                    var subscription = response['subscription'][i];
                    $('#display').append(
                        count + ' - New subscription added by customer with id <strong>' + subscription['customer_id'] + '</strong>, with subscription id <strong>' + subscription['id'] + '</strong>'
                    );
                    count++;
                }
            });
        });
        
    })
    
</script>
@endpush

    