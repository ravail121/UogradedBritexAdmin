@push('js')
<script>
    
    $(function(){
        
        $('#payment-tab').click(function() {

            $('#title').html('Payment Logs'+'<hr>');

            $('#display').html('');

            $('.cron-logs-display').addClass('display-none');

            $.ajax({
                url:'{{ route("cron.get-logs") }}',
                method:'GET',
                dataType:'json'

            }).done(function(response) {

                if (response['paymentLog'].length === 0) {
                    $('#display').append('No logs today');
                }                
                var count = 1;
                for (let i = 0; i < response['paymentLog'].length; i++) {
                    var payment = response['paymentLog'][i];
                    $('#display').append(
                       count + ' - Payment of <strong>' + payment['amount'] + '</strong> by the customer with id <strong>' + payment['customer_id'] + '</strong><br>'                    
                    );
                    count++;
                }
            });
        });

    })

    /*
                            '<h4>Payment id: '+response['paymentLog'][i]["id"]+'</h4>'+
                        '<small>Customer id: <b>'+response['paymentLog'][i]["customer_id"]+'</b></small>, '+
                        '<small>Order id: <b>'+response['paymentLog'][i]["order_id"]+'</b></small>, '+
                        '<small>Transaction id: <b>'+response['paymentLog'][i]["transaction_num"]+'</b></small>, '+
                        '<small>Status: <b>'+response['paymentLog'][i]["error"]+'</b></small>, '+
                        '<small>Card Type: <b>'+response['paymentLog'][i]["card_type"]+'</b></small>, '+
                        '<small>Amount: <b>'+response['paymentLog'][i]["amount"]+'</b></small><hr>'+
                        '<small>Date: <b>'+response['paymentLog'][i]["created_at"]+'</b></small><hr><br>'
    */
    
</script>
@endpush
    
    