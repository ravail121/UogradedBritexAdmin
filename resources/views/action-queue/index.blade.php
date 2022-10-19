@extends('layouts._app-auth')

@section('body-class')

@endsection

@section('page-title')
Action-Queue
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mnguserbxs">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <h1 class="">Active</h1>
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
								<a class="nav-link active shipping-tab-btn" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="true">Shipping</a>
							</li>
							<li class="nav-item">
								<a class="nav-link activation-tab-btn" id="activation-tab" data-toggle="tab" href="#activation" role="tab" aria-controls="activation" aria-selected="false">Activation</a>
							</li>
							<li class="nav-item">
								<a class="nav-link reactivation-tab-btn" id="reactivation-tab" data-toggle="tab" href="#reactivation" role="tab" aria-controls="reactivation" aria-selected="false">FOR-REActivation</a>
							</li>
							<li class="nav-item">
								<a class="nav-link cloud-activation-tab-btn" id="cloudact-tab" data-toggle="tab" href="#cloudact" role="tab" aria-controls="cloudact" aria-selected="false">Cloud Activation</a>
							</li>
							<li class="nav-item">
								<a class="nav-link porting-tab-btn" id="porting-tab" data-toggle="tab" href="#porting" role="tab" aria-controls="porting" aria-selected="false">PORTING</a>
							</li>
							<li class="nav-item">
								<a class="nav-link upgrade" id="updowngrade-tab" data-toggle="tab" href="#updowngrade" role="tab" aria-controls="updowngrade" aria-selected="false">UP/DOWNGRADE</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active-tab-btn" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="false">ACTIVE</a>
							</li>
							<li class="nav-item">
								<a class="nav-link past-due-tab-btn" id="forsusp-tab" data-toggle="tab" href="#forsusp" role="tab" aria-controls="forsusp" aria-selected="false">PAST DUE</a>
							</li>
							<li class="nav-item">
								<a class="nav-link suspended-tab-btn" id="finalsuspen-tab" data-toggle="tab" href="#finalsuspen" role="tab" aria-controls="finalsuspen" aria-selected="false">SUSPENDED</a>
							</li>
							<li class="nav-item">
								<a class="nav-link closed-tab-btn" id="closed-tab" data-toggle="tab" href="#closed" role="tab" aria-controls="closed" aria-selected="false">CLOSED</a>
							</li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        @include('action-queue._shipping')
                        @include('action-queue._activation')
                        @include('action-queue._for-reactivation')
                        @include('action-queue._cloud-activation')
                        @include('action-queue._porting')
                        @include('action-queue._upgrade-downgrade')
                        @include('action-queue._active')
                        @include('action-queue._past-due')
                        @include('action-queue._suspended')
                        @include('action-queue._closed')
                        {{-- @include('action-queue._extras') --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(function(){
            let tabIndex = {{ isset($_GET['tab_index']) ? $_GET['tab_index']: '0' }}
            $('.nav-item').eq(tabIndex).find('a').click();

            $('#phone_number').mask('000-000-0000', {
                'translation': {
                    0: {
                        pattern: /[0-9*]/
                    }
                }
            });
        });
    </script>
@endpush