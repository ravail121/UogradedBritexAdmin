@extends('layouts._app-auth')

@push('css')
    {!! Html::style('https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css') !!}
    {!! Html::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') !!}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap2.css') !!}
@endpush

@section('body-class')

@endsection

@section('page-title')
Cron Jobs Tester
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mnguserbxs">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <h1 class="">Cron Testing</h1>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-8"> </div>
    </div>

    <div class="tabsdata">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="tabstable">
                    <div class="tabsbx">
                        <ul class="nav nav-tabs actionquetabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="order-tab" aria-selected="true">Order Logs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab" aria-controls="invoice-tab" aria-selected="false">Invoice Logs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="business-tab" data-toggle="tab" href="#business" role="tab" aria-controls="business-tab" aria-selected="false">Business Verify Logs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment-tab" aria-selected="false">Payment Logs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="subscription-tab" data-toggle="tab" href="#subscription" role="tab" aria-controls="subscription-tab" aria-selected="false">Subscription Logs</a>
                            </li>
                        </ul>
                    </div>

                    <div class='container'>
    
                        @include('cron-logs._tester')

                    </div>

                    <h3 class='container' id='title'></h3> 

                    <div class='container' id='display'>
                        
                    </div>                 
                    
                    <div class="tab-content container" id="myTabContent">

                        @include('cron-logs._order-logs')
                        @include('cron-logs._invoice-logs')
                        @include('cron-logs._business-logs')
                        @include('cron-logs._payment-logs')
                        @include('cron-logs._subscription-logs')

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

    {!! Html::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js') !!}
    {!! Html::script('https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js') !!}
    {!! Html::script('https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js') !!}

    <script>

    </script>

@endpush

