@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.css" integrity="sha512-HcfKB3Y0Dvf+k1XOwAD6d0LXRFpCnwsapllBQIvvLtO2KMTa0nI5MtuTv3DuawpsiA0ztTeu690DnMux/SuXJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {!! Html::style('theme/css/style81.css') !!}
    {!! Html::style('theme/css/effect81.css') !!}
    {!! Html::style('theme/css/checkstyle.css') !!}
    {!! Html::style('theme/css/sidebarstyle.css') !!}
    {!! Html::style('theme/selectbx/css/nice-select.css') !!}
    {!! Html::style('css/vendors/datetimepicker.css') !!}
    {!! Html::style('css/vendors/jquery.datetimepicker.css') !!}
    {!! Html::style('css/vendors/dropzone.css') !!}
    {!! Html::style('css/vendors/dataTables.bootstrap.min.css') !!}
    {!! Html::style('css/vendors/bootstrap-tagsinput.css') !!}
@endpush

@section('loader-image')
    <div class="my-overlay display-none"></div>
    <div class="loading-gif display-none">
        <img src="{{ asset('theme/img/loader.gif') }}" />
    </div>
@endsection
<form action="{{ route('search.customer') }}" id="search">
    <input type="hidden" name="" id="searchIteam" value="">
</form>
@section('side-bar')
    @include('layouts.partials._sidebar')
@endsection

@section('header')
    @include('layouts.partials._header')
@endsection


{{-- @section('validate-js')
    <script>$('form').each(function(){  $(this).validate(); });</script>
@endsection --}}

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            if(window.location.href.indexOf('?phone') > 0) {
                $('.searchPhone1').parents('li').addClass('active');
                $('.searchPhone').parents('li').addClass('active');
            } else if(window.location.href.indexOf('?name') > 0) {
                $('.searchName1').parents('li').addClass('active');
                $('.searchName').parents('li').addClass('active');
            } else if(window.location.href.indexOf('?sim') > 0) {
                $('.searchSIM1').parents('li').addClass('active');
                $('.searchSIM1').parents('li').addClass('active');
            }else if(window.location.href.indexOf('?company') > 0) {
                $('.searchPhone1').parents('li').addClass('active');
                $('.searchPhone1').parents('li').addClass('active');
            } else {
                $('.searchPhone1').parents('li').addClass('active');
                $('.searchPhone').parents('li').addClass('active');
            }
            var searchedValue = localStorage.getItem('searchitem');
            //var searchedValue2 = localStorage.getItem('searchitem2');
            if(searchedValue != null) {
                $('#validationDefaultUsername').val(searchedValue);
                $('#validationDefaultUsername2').val(searchedValue);
            }
            $('#validationDefaultUsername2').keypress(function(e){
                if(e.which == 13){//Enter key pressed
                    if(window.location.href.indexOf('?phone') > 0) {
                        searchPhone($(this).val());
                    } else if(window.location.href.indexOf('?name') > 0) {
                        searchName($(this).val());
                    }else if(window.location.href.indexOf('?sim') > 0) {
                        searchSIM($(this).val());
                    } else {
                        searchPhone($(this).val());
                    }
                }
            });
            $('#validationDefaultUsername').keypress(function(e){
                if(e.which == 13){//Enter key pressed
                    if(window.location.href.indexOf('?phone') > 0) {
                        searchPhone($(this).val());
                    } else if(window.location.href.indexOf('?name') > 0) {
                        searchName($(this).val());
                    } else if(window.location.href.indexOf('?sim') > 0) {
                        searchSIM($(this).val());
                    } else if(window.location.href.indexOf('?company') > 0) {
                        searchCompany($(this).val());
                    } else {
                        searchPhone($(this).val());
                    }
                }
            });
            $('.searchPhone1').on('click', function(e){
                var searchText = $('#validationDefaultUsername2').val();
                searchPhone(searchText);
            });
            $('.searchPhone').on('click', function(e){
                var searchText = $('#validationDefaultUsername').val();
                searchPhone(searchText);
            });

            function searchPhone(searchText) {
                if(searchText == '') {
                    swal('Please Enter Phone, Name, SIM No. or Company');
                } else {
                    $('#searchIteam').attr('name', 'phone');
                    $('#searchIteam').val(searchText);
                    $('#search').submit();
                }
                localStorage.setItem("searchitem", searchText);
            }
            function searchName(searchText) {
                if(searchText == '') {
                    swal('Please Enter Phone, Name, SIM No. or Company');
                } else {
                    $('#searchIteam').attr('name', 'name');
                    $('#searchIteam').val(searchText);
                    $('#search').submit();
                }
                localStorage.setItem("searchitem", searchText);
            }

            function searchSIM(searchText) {
                if(searchText === '') {
                    swal('Please Enter Phone, Name, SIM No. or Company');
                } else {
                    $('#searchIteam').attr('name', 'sim');
                    $('#searchIteam').val(searchText);
                    $('#search').submit();
                }
                localStorage.setItem("searchitem", searchText);
            }

            function searchCompany(searchText) {
                if(searchText === '') {
                    swal('Please Enter Phone, Name, SIM No. or Company');
                } else {
                    $('#searchIteam').attr('name', 'company');
                    $('#searchIteam').val(searchText);
                    $('#search').submit();
                }
                localStorage.setItem("searchitem", searchText);
            }

            $('.searchName').on('click', function(e){
                var searchText = $('#validationDefaultUsername').val();
                searchName(searchText);
            });
            $('.searchName1').on('click', function(e){
                var searchText = $('#validationDefaultUsername2').val();
                searchName(searchText);
            });

            $('.searchSIM').on('click', function(e){
                var searchText = $('#validationDefaultUsername').val();
                searchSIM(searchText);
            });
            $('.searchSIM1').on('click', function(e){
                var searchText = $('#validationDefaultUsername2').val();
                searchSIM(searchText);
            });

            $('.searchCompany').on('click', function(e){
                var searchText = $('#validationDefaultUsername').val();
                searchCompany(searchText);
            });
            $('.searchCompany1').on('click', function(e){
                var searchText = $('#validationDefaultUsername2').val();
                searchCompany(searchText);
            });

            $('.addnotebtnmain').on('click', function () {
                $('.notesbxnew').toggleClass('active');
            });
            $('.addnotebtnmain2').on('click', function () {
                $('.notesbxnew2_new').toggle('fast');
                $('.notesbxnew3_new').toggle('fast');
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
                $('.srchcontent').toggleClass('active');
            });

            // $('select:not(.ignore)').niceSelect();      
            // FastClick.attach(document.body);
        });
    </script>
    <!-- Custom Selctbx All JS -->
    {!! Html::script('theme/selectbx/js/fastclick.js') !!}
    {{-- {!! Html::script('theme/selectbx/js/jquery.js') !!} --}}
    {!! Html::script('theme/selectbx/js/jquery.nice-select.min.js') !!}
    {!! Html::script('theme/selectbx/js/prism.js') !!}
    <script type="text/javascript">
        var amount = '';
        function scroll() {
            $('.week_container').animate({
                scrollLeft: amount
            }, 50, 'linear', function() {
                if (amount != '') {
                    scroll();
                }
            });
        }

        //scroll left
        $('.hover-left').hover(function() {
            amount = '-=10';
            scroll();
        }, function() {
            amount = '';
        });

        //scroll right
        $('.hover-right').hover(function() {
            amount = '+=10';
            scroll();
        }, function() {
            amount = '';
        });


        //refund trigger
        $(".refundpurplebtn").click(function(){
            $(this).next('.refund_trigger').toggle();
            $(this).toggle();
        });


        $(".crossbtn").click(function(){
            $(this).parents('.refund_trigger').hide();
            $(this).closest('.creditform').children('.refundpurplebtn').show();
        });
    </script>
    {!! Html::script('theme/js/select.js') !!}
    <!--- for mask -->
    {!! Html::script('theme/js/jquery.mask.js') !!}
    <script>
        function showLoader() {
            $('.my-overlay').removeClass('display-none');
            $('.loading-gif').removeClass('display-none');
        }

        function hideLoader() {
            $('.my-overlay').addClass('display-none');
            $('.loading-gif').addClass('display-none');
        }

        $('.nav-item').on('click', function() {
            window.history.replaceState(null, null, "?tab_index="+$(this).index());
        });

        window.firstXhrError = function(xhr){
            const responseText = JSON.parse(xhr.responseText),

                errorsArray = responseText.errors,
                errorMessage = responseText.message;

            if(errorsArray !== undefined){
                error = Object.values(errorsArray).shift()[0]
            }

            else if(errorMessage !== undefined){
                error = errorMessage;
            }

            else {
                error = 'Something went wrong. Try again later';
            }

            typeof swal !== 'undefined'
                ? swal(error)
                : alert(error);
        }
    </script>

    <script src="{{ asset('js/vendors/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/vendors/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('js/vendors/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/vendors/dataTables.bootstrap.min.js') }}"></script>

    <script src="{{ asset('js/vendors/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('js/vendors/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('js/vendors/dropzone-amd-module.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.js"></script>
@endpush