@extends('layouts._app-auth')

@push('css')
    <style>
        .dl {
            padding: 3px 20px !important;
            font-size: 12px !important;
        }
    </style>
@endpush

@section('body-class')
    class="actionquee"
@endsection

@section('page-title')
    Support
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mnguserbxs">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <h1 class=""><span>Active</span>
                    <span>&nbsp;</span>
                    <span class="actionbtn"><a class="btn markbtn createcatbtn" href="#createCategory" data-toggle="modal" data-target="#createCategory" id="createcatbtn">Create New Category</a></span></h1>
            </div>
        </div>

        <div class="tabsdata">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="tabstable">
                        <div class="tabsbx">
                            <ul class="nav nav-tabs actionquetabs" id="myTab" role="tablist">
                                @foreach($categories as $category)
                                    @if($category->id == 1)
                                        <li class="nav-item active">
                                            <a class="nav-link faq-tab-btn active" id="faq-tab" data-toggle="tab" data-id="{{$category->id}}" href="#faq" role="tab" aria-controls="faq" aria-selected="false">{{$category->name}}</a>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a class="nav-link faq-tab-btn" id="faq-tab" data-toggle="tab" data-id="{{$category->id}}" href="#faq" role="tab" aria-controls="faq" aria-selected="false">{{$category->name}}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @isset($categories['0'])
                            <div class="tab-content" id="myTabContent">
                                @include('faq._pre-sale')
                            </div>
                        @else
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 no-data-msg">
                                    <span>No Record Found</span>
                                </div>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('faq._create_category')

@endsection

@push('js')
    <script>
        $(function(){
            let tabIndex = {{ isset($_GET['tab_index']) ? $_GET['tab_index']: '0' }}
            $('.nav-item').eq(tabIndex).find('a').click();
        });
    </script>
@endpush