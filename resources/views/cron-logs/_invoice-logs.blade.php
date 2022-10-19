@push('js')
<script>

    $(function(){

        $('#invoice-tab').click(function() {

            $('#title').html('Invoice'+'<hr>');

            $('#display').html('');

            $('.cron-logs-display').addClass('display-none');

            $.ajax({

                url:'{{ route("cron.get-logs") }}',
                method:'GET',
                dataType:'json'

            }).done(function(response) {

                if (response['invoice'].length === 0) {
                    $('#display').append('No logs today');
                }
                
                var count = 1;
                for (let i = 0; i < response['invoice'].length; i++) {
                    var invoice = response['invoice'][i];
                    var pdf     = response['invoicePdf'];
                    $('#display').append(
                        invoice['id'] + 
                        ' - Invoice generated for <strong>' + invoice['billing_fname']+ ' '+invoice['billing_lname'] + '</strong>' +
                        ' download ' + pdf[i] + ', email sent to <strong>' + invoice['billing_fname']+ ' '+invoice['billing_lname'] + '</strong><br>'
                    );
                    count++;
                }
            });

        });

    });
</script>
@endpush

