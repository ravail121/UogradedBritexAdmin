@extends('layouts._app-auth')

@section('page-title')
    Go-Know
@endsection

@section('loader-image')
    <div class="my-overlay"></div>
    <div class="loading-gif">
        <img src="{{ asset('theme/img/loader.gif') }}" />
    </div>
@endsection

@section('content')
<div class="subscbx bgwhite padding-10">
    <div style="text-align: center; color: red; width: 100%; margin-bottom: 20px; margin-top: 20px;">
        @if(!is_object($errors))
            {{ $errors }}
        @endisset
    </div>

    @include('go-know.partials._restore_line')
    @include('go-know.partials._suspend_line')
    @include('go-know.partials._sim_changes')
    @include('go-know.partials._areacode_changes')
    @include('go-know.partials._export_csv')
</div>


@endsection

@push('js')
@endpush