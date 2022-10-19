@extends('layouts._app-auth')
@push('css')
    <style>
        .searchData .table.audittable tr:nth-child(2), .subscribersdata .table.audittable td:nth-child(2) {
            text-align: center !important;
        }
    </style>
@endpush
@section('page-title')
    Customers
@endsection

@section('content')
    <div class="subscbx bgwhite">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-10">
                    <h1><span><img src="{{ asset("theme/img/active_img.png") }}" width="11" height="11" alt=""/></span>Customers</h1>
                </div>
            </div>
        </div>
        <div class="subscribersdata business">
            <div class="table-responsive">
                <table class="table audittable tablecentertxt" id="table">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        @if(isset($subscription))
                            <th scope="col">SIM</th>
                        @endif
                        <th scoope="col">Company</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($subscription))
                        @foreach($subscription as $customer)
                            <tr>
                                <td></td>
                                <td>{{ $customer->customer['id'] }}</td>
                                <td><a href="{{ route('customers.detail', $customer->customer['id'])}}">{{ $customer->customer['fullname'] }}</a></td>
                                <td>{{ $customer->customer['email'] }}</td>
                                <td>{{ $customer->customer['phone'] }}</td>
                                <td>{{ $customer['sim_card_num'] }}</td>
                                <td>{{ $customer->customer['company_name'] }}</td>
                            </tr>
                        @endforeach
                    @elseif(isset($customers))
                        @foreach($customers as $customer)
                            <tr>
                                <td></td>
                                <td>{{ $customer->id }}</td>
                                <td><a href="{{ route('customers.detail', $customer->id) }}">{{ $customer->fullname }}</a></td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->company_name }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function () {
            $('#table').DataTable({
                searching: false,
                "oLanguage": {
                    "sEmptyTable":     "No record present"
                }
            });
        });
    </script>
@endpush