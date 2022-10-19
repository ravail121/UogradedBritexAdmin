@extends('layouts._app-auth')

@section('page-title')
    Due Check
@endsection

@section('content')

<div class="table-responsive">
    <table class="table audittable tablecentertxt" id="table">
        <thead>
            <tr>
                <th scope="col" class = "no-sort-option">Cust ID</th>
                <th scope="col" class = "no-sort-option">Cust Name</th>
                <th scope="col" class = "no-sort-option">Cust. Portal Due</th>
                <th scope="col" class = "no-sort-option">Cron AutoPay Due</th>
                <th scope="col" class = "no-sort-option">Admin Due/Credit</th>
            </tr>
        </thead>
        <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer['id']  }}</td>
                    <td>{{ $customer['name']  }}</td>
                    <td>{{ $customer['portal_due'] }}</td>
                    <td>{{ $customer['autopay_due'] }}</td>
                    <td>{{ number_format($customer['admin_due'], 2)   }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('js')
@endpush