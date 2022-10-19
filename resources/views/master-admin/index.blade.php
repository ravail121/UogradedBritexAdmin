@extends('layouts._app-auth')

@section('body-class')
class="actionquee"
@endsection

@section('page-title')
    MasterAdmin
@endsection

@section('content')
<div class="subscbx bgwhite">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
                <h1><span><img src="{{ asset("theme/img/active_img.png") }}" width="11" height="11" alt=""/></span>All Company</h1>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
                <div class="actionbtn"> 
                    <a class="btn markbtn createbtn" href="{{ route( 'reseller.form') }}" >Add New Company</a> 
                </div>
            </div>
        </div>
    </div>
    <div class="subscribersdata">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="custom-width">ID</th>
                        <th scope="col">Logo</th>
                        <th scope="col">URL</th>
                        <th scope="col">API Key</th>
                        <th scope="col" class="custom-name-width">Name</th>
                        <th scope="col">Support Email</th>
                        <th scope="col">Support Phone</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $key => $company)
                    <tr>
                        <td>{{ $company->id }}</td>
                        <td>
                            @if($company->logo)
                                <img class="logo-list" src="{{ $company->logo }}">
                            @endif
                        </td>
                        <td>{{ $company->url }}</td>
                        <td>{{ $company->api_key }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->support_email }}</td>
                        <td>{{ $company->support_phone_number_formatted }}</td>
                        <td>
                            <div class="dropdown"> 
                                <a class="btn markbtn activest smgreen edit-btn" href="{{ route( 'edit.company', $company->id) }}"> Edit </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <nav aria-label="Page navigation example" class="mypagination">
                    {!! $companies->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                </nav>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    
@endpush