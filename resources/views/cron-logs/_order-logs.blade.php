@push('js')
<script>  
    $(function(){
        
        $('#orders-tab').click(function() {

            $('#title').html('Orders'+'<hr>');

            $('#display').html('');

            $('.cron-logs-display').addClass('display-none');

            $.ajax({

                url:'{{ route("cron.get-logs") }}',
                method:'GET',
                dataType:'json'

            }).done(function(response) {

                if (response['orders'].length === 0) {
                    $('#display').append('No logs today');
                }       

                var count = 1;
                for (let i = 0; i < response['orders'].length; i++) {
                    var order =  response['orders'][i];
                    if (order['invoice_id'] != null) {
                        $('#display').append(
                            count + ' - Order placed with invoice id <strong>' + order['invoice_id'] + '</strong>' +
                            ' by customer with id <strong>' + order['customer_id'] + '</strong><br>'
                        );
                        count++;
                    }
                }
            });
        });

    })
</script>
@endpush

