<div class="tab-pane fade " id="bh" role="tabpanel" aria-labelledby="bh-tab">
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src="{{ asset('theme/img/active_img.png') }}" width="11" height="11" alt=""/></span>Billing History</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right"> </div>
            </div>
        </div>
        <div class="subscribersdata billingdata">
            <div class="table-responsive">
                <table class="table audittable" id ="customer-billing-history-table">
                    <thead>
                        <tr>
                            <th scope="col" class = "custom-agent-width">Agent</th>
                            <th scope="col" class = "">Date</th>
                            <th scope="col" class = "custom-type-width">Type</th>
                            <th scope="col" class = "">Amount</th>
                            <th scope="col" class = "">Balance</th>
                            <th scope="col" class="text-center">Payment type</th>
                            <th scope="col" class = "custom-width">Notes</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="subscbx">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h1><span><img src="{{ asset('theme/img/active_img.png') }}" width="11" height="11" alt=""/></span>USAePAY Transactions</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right"> </div>
            </div>
        </div>
        <div class="subscribersdata">
            <div class="table-responsive">
                <table class="table audittable" id = "customer-payment-log-table">
                    <thead>
                        <tr>
                            <th scope="col" class="custom-width">Date</th>
                            <th scope="col" class="text-center">Transaction No.</th>
                            <th scope="col">USAePay Ref. No.</th>
                            <th scope="col">CC Last 4 Digit</th>
                            <th scope="col">Total</th>
                           {{--  <th scope="col" class="custom-width">Refunds Issued</th> --}}
                            <th scope="col" class="custom-width">Status</th>
                            <th scope="col">Error</th>
                            <th scope="col">Do Refund</th>
                            <th scope="col">Refund Details</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
$(function(){
    $('.billing-history-tab-btn').on('click', loadBillingHistoryData);

    function loadBillingHistoryData() {
        billingInfoTable = loadBillingHistoryTable();
        paymentLogTable = loadPaymentLogTable();
        return paymentLogTable;
    }

    function loadBillingHistoryTable() {
        let billingInfoTable = $('#customer-billing-history-table').DataTable({
            "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
            "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ordering": false,
            "info": true,
            "bDestroy": true,
            "order": [[ 1, "desc" ]],
            "ajax": {
                "url": "{{URL::route('customer.billing.history.datatables', $customer->id) }}",
                "data": function ( d ) {
                    d.isClose = true;
                },
                beforeSend: showLoader,
                complete: hideLoader,
            },
            "language": {
                "processing": "Please Wait...",
            },
            "columns": [
                { "data": 'agent', 'orderable': false },
                { "data": 'date' },
                { "data": 'type', 'orderable': false },
                { "data": 'amount', 'orderable': false },
                { "data": 'balance', 'orderable': false},
                {
                    "data": 'payment-type', 'orderable': false
                },
                {
                    "data": 'note',
                    "orderable": false,
                },
                { "data": 'detail', 'orderable': false },
            ]
        });
        return billingInfoTable;
    }

    function loadPaymentLogTable() {
        let paymentLogTable = $('#customer-payment-log-table').DataTable({
            "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "info": true,
            "bDestroy": true,
            "order": [[ 0, "desc" ]],
            "ajax": {
                "url": "{{URL::route('customer.payment.log.datatables', $customer->id) }}",
                "data": function ( d ) {
                    d.isClose = true;
                },
                beforeSend: showLoader,
                complete: hideLoader,
            },
            "language": {
                "processing": "Please Wait...",
            },
            "columns": [
                { "data": 'date' },
                { "data": 'transaction_num' },
                { "data": 'refno' },
                { "data": 'last4' },
                { "data": 'total' },
                // { "data": 'refund_issue' },
                { "data": 'status' },
                { "data": 'error' },
                {
                    "data": 'refund',
                    "orderable": false,
                },
                {
                    "class": "more-btn",
                    "data": 'details',
                    "orderable": false,
                },
            ]
        });
        return paymentLogTable;
    }

    $('body').on('click','.refund-action .refund-btn', function() {
        $this = $(this);
        $this.parents(".actionbtn").find('.refund-confirm-btn').removeClass('display-none');
        $this.addClass("display-none");
    });

    $('body').on('click','.refund-confirm-btn .refund-confirm-close-btn', function() {
        $this = $(this);
        $this.parents(".actionbtn").find('.refund-confirm-btn').addClass('display-none');
        $this.parents(".actionbtn").find('.refund-btn').removeClass('display-none');
    });

    $('body').on('click','.refund-confirm-btn .confirm-refund-btn', function() {
        $this = $(this).parents(".actionbtn");
        $input = $this.find('#refund-amount');
        if($input.val() == ""){
            swal("Please Porvide a valid Amount")
        }
        else if(parseFloat($input.attr('amount')) >= parseFloat($input.val())){
            $form = $(this).parents(".actionbtn").find('#payment-log-form');
            processRefund($form);
        }else{
            swal("Refund amount exceeds original charge minus refunds already given");
        }
    });

    function processRefund($form) {
        let formData = $($form).serialize();
        $.ajax({
            type: 'POST',
            url: '{{ route('process.refund') }}',
            dataType: 'json',
            data:formData,
            beforeSend: showLoader,
            success: function (data) {
                if(data.error){
                    swal("Error!",data.error ,"error");
                }else{
                    swal("Success!",'Refund Processed Successfully' , "success");
                }
                loadBillingHistoryData();
            },
            complete: hideLoader,
            error: function (xhr,status,error) {
                firstXhrError(xhr);
            }
        });
    }

    $('#customer-payment-log-table').on( 'click', 'tr td.more-btn', function () {
        let tr = $(this).closest('tr');
        let row = paymentLogTable.row( tr );
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( refundDetail(row.data()) ).show();
            tr.addClass('shown');
        }
    });

    function refundDetail(data) {
        if (data.payment_refund_log.length) {
            let tableRow = '<tr>'+
                '<th></th>'+
                '<th class="text-center">Date</th>'+
                '<th class="text-center">Transaction No.</th>'+
                '<th class="text-center">Status</th>'+
                '<th class="text-center">Error</th>'+
                '<th class="text-center">Amount</th>'+
            '</tr>';
            data.payment_refund_log.forEach(function(refundLog, key) {
                tableRow += '<tr>'+
                    '<td></td>'+
                    '<td>'+refundLog.created_at_formatted+'</td>'+
                    '<td>'+refundLog.transaction_no_formatted+'</td>'+
                    '<td>'+refundLog.status_formatted+'</td>'+
                    '<td>'+refundLog.error+'</td>'+
                    '<td>$'+refundLog.amount_formatted+'</td>'+
                '</tr>'
            });

        return '<table class="width-100 refund-record" cellpadding="5" cellspacing="0" border="0">'+
            tableRow
        '</table>';
        }else{
            return 'No Refund Record Found';
        }
    }

    $('#customer-billing-history-table').on( 'click', 'tr td .credit-info', function (e) {
        e.preventDefault();
        let tr = $(this).closest('tr');
        let row = billingInfoTable.row( tr );
        if ( row.child.isShown() ) {
            $('div.sliderabc', row.child()).slideUp( function () {
                row.child.hide();
                tr.removeClass('shown');
            } );
        }
        else {
            row.child( creditDetail(row.data()), 'no-padding' ).show();
            tr.addClass('shown');
            $('div.sliderabc', row.child()).slideDown();
        }
    });

    function creditDetail(data) {
        if (data.used_credit.length) {
            let tableRow = '<tr>'+
                '<th></th>'+
                '<th class="text-center">Date</th>'+
                '<th class="text-center">Invoice/Credit ID</th>'+
                '<th class="text-center">Amount</th>'+
                '<th class="text-center">Description</th>'+
            '</tr>';
            data.used_credit.forEach(function(creditData, key) {
                tableRow += '<tr>'+
                    '<td></td>'+
                    '<td>'+creditData.created_at+'</td>'+
                    '<td>'+creditData.id+'</td>'+
                    '<td>'+creditData.pivot.amount+'</td>'+
                    '<td>$'+creditData.pivot.description+'</td>'+
                '</tr>'
            });

        return '<div class="sliderabc">' + '<table class="width-100 refund-record" cellpadding="5" cellspacing="0" border="0">'+
            tableRow
        '</table>' + '</div>';
        }else{
            return '<div class="sliderabc">' + 'No Credit info Found'+ '</div>';
        }
    }

});
</script>
<style>
    div.sliderabc {
        display: none;
    }

    table.dataTable tbody td.no-padding {
        padding: 0;
        background-color: ghostwhite;
    }
</style>
@endpush