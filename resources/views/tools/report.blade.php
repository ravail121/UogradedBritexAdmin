@extends('layouts._app-auth')

@section('page-title')
    Due Check
@endsection

@section('content')

<div class="table-responsive">
    <table class="table audittable tablecentertxt" id="table">
        <thead>
            <tr>
                <th scope="col" class = "no-sort-option">ID</th>
                <th scope="col" class = "no-sort-option">Customer ID</th>
                <th scope="col" class = "no-sort-option">Subtotal</th>
                <th scope="col" class = "no-sort-option">Invoice Item</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoic)
                <tr>
                    @if((round(($invoic->sumtotal -  $invoic->sumcoupon),2) !=  $invoic['subtotal'])   )
                        <td>{{ $invoic['id']  }}</td>
                        <td>{{ $invoic['customer_id']  }}</td>
                        <td>{{ $invoic['subtotal']  }}</td>
                        <td>{{ $invoic->sumtotal -  $invoic->sumcoupon }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('js')
@endpush