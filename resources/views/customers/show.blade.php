@extends('layouts._app-auth')

@push('css')
    {!! Html::style('css/vendors/selectize.bootstrap2.css') !!}
@endpush

@section('page-title')
    Customer Details
@endsection

@section('loader-image')
    <div class="my-overlay display-none"></div>
    <div class="loading-gif display-none">
        <img src="{{ asset('theme/img/loader.gif') }}" />
    </div>
@endsection

@section('content')
<div class="container-fluid"> 
    <div class="row mnguserbxs">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <h1 class="hidden-xs">Manage Account <a href="{{ $customer->company->url }}/user-login/{{ bin2hex($customer->hash) }}" target="_blank" ><button class="btn btn-dark">Login as User</button></a></h1>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-8">
            <h1>Overview</h1>
        </div>
    </div>
    <div class="row mnguserbxs">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <div class="mnguserbx">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="mngusertxt customer-info"> 
                            <a href="#editpop" class="mngusereditbtn" data-toggle="modal" data-target="#editpop">
                                <span class="fas fa-pencil-alt"></span>
                            </a>
                            <span class="grid-display">
                                <h1 class="fullname">{{ $customer->full_name }}<p class="companyname float-right paddind-r-5">{{ $customer->company_name }}</p></h1>
                                <p>
                                    <p><a class="email" href="mailto:{{$customer->email}}"><span class="fas fa-envelope-open"></span>{{$customer->email}}</a></p>
                                </p>
                            </span>
                            <p><a href="#"><span class="fas fa-phone"></span></a><span class="customer-phone" >{{$customer->phoneNumberFormatted}}</span>
                            </p>
                            <p><a href="#"><span class="fas fa-id-badge"></span>PIN:</a><span class="customer-pin" >{{$customer->pin}}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <div class="creditbx">
                <div class="row">
                    <div class="col-sm-12 col-md-5 align-items-center justify-content-center">
                        <div class="creditbximg icon_credit text-right "> 
                            <img src="{{ asset('theme/img/icon_credit.png') }}" class="img-fluid" alt=""/> 
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7 align-items-center justify-content-center">
                        <div class="creditbxtxt text-right">
                            @if ($customer->amount_due <= 0)
                                <p>Credit</p>
                            @else
                                <p>Amount Due</p>
                            @endif
                            <h5>${{ number_format($customer->credits_count, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <div class="creditbx">
                <div class="row">
                    <div class="col-sm-12 col-md-4 align-items-center justify-content-center">
                        <div class="creditbximg icon_duedate text-right "> 
                            <img src="{{ asset('theme/img/icon_duedate.png') }}" class="img-fluid" alt=""/> 
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8 align-items-center justify-content-center">
                        <div class="creditbxtxt text-right">
                            <p>Due Date</p>
                             <h5>{{ $customer->pendingPaymentInvoices->count() ? $customer->pendingPaymentInvoices->last()->due_date_formatted: $customer->billing_end_formatted }}
                             </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($customer->account_suspended)
            <h1 class ="account-suspended">Account Suspended<h1>
        @endif
    </div>
    <!-- Top boxs ends --> 
  
    <!-- Table Data -->
    <div class="tabsdata">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="tabstable">
                    <div class="tabsbx">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item"> 
                                <a class="nav-link subscription-tab-btn" id="subscriptions-tab" data-toggle="tab" href="#subscriptions" role="tab" aria-controls="subscriptions" aria-selected="true">Subscriptions</a> 
                            </li>
                            <li class="nav-item"> 
                                <a class="nav-link" id="acinfo-tab" data-toggle="tab" href="#acinfo" role="tab" aria-controls="acinfo" aria-selected="false">Shipping Information</a> 
                            </li>
                            <li class="nav-item"> 
                                <a class="nav-link" id="billing-tab" data-toggle="tab" href="#billing" role="tab" aria-controls="billing" aria-selected="false">Billing</a> 
                            </li>
                            <li class="nav-item"> 
                                <a class="nav-link billing-history-tab-btn" id="bh-tab" data-toggle="tab" href="#bh" role="tab" aria-controls="bh" aria-selected="false">Billing History</a> 
                            </li>
                            <li class="nav-item"> 
                                <a class="nav-link" id="eh-tab" data-toggle="tab" href="#eh" role="tab" aria-controls="eh" aria-selected="false">EMAIL HISTORY</a> 
                            </li>
                            <li class="nav-item"> 
                                <a class="nav-link" id="log-tab" data-toggle="tab" href="#log" role="tab" aria-controls="eh" aria-selected="false">LOGS</a> 
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ach-tab" data-toggle="tab" href="#ach" role="tab" aria-controls="ach" aria-selected="false">SUBSCRIPTION CHANGES</a>
                            </li>
                        </ul>
                    </div>
                     <div class="tab-content" id="myTabContent">
                         @include('customers._subscription')
                         @include('customers._shipping-information')
                         @include('customers._billing')
                         @include('customers._billing-history')
                         @include('customers._email-history')
                         @include('customers._logs')
                         @include('customers._subscription-changes')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="editpop" tabindex="-1" role="dialog" aria-labelledby="editpopup" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close update-customer-close-btn" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx margin-bottom40">
                        <h1>Manage Account</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <div class="topdrtxt">
                    <h2>Edit Profile</h2>
                </div>
                <form id = "customer-detail-form" class="customer-update">
                    <div class="row">
                        <input type="hidden" name="id" value="{{ $customer->id }}">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="fname">First Name<span class="text-danger"> *</span></label>
                            <input type="text" class="form-control effect-1" id = "fname" name = "fname" aria-describedby="emailHelp" value ="{{ $customer->fname }}" placeholder="Enter First Name">
                            <span class="focus-border"></span> </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="customer-lname">Last Name<span class="text-danger"> *</span></label>
                            <input type="text" class="form-control effect-1" id="lname" name="lname" aria-describedby="emailHelp" value ="{{ $customer->lname }}" placeholder="Enter Last Name">
                            <span class="focus-border"></span> </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="email">Email<span class="text-danger"> *</span></label>
                            <input type="email" id="email" name="email" class="form-control effect-1" aria-describedby="emailHelp"
                            value ="{{ $customer->email }}" placeholder="Enter Email Address">
                            <span class="focus-border"></span> </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="company">Company</label>
                            <input type="text" id="company" name="company_name" class="form-control effect-1" aria-describedby="emailHelp" value ="{{ $customer->company_name }}" placeholder="Enter Company">
                            <span class="focus-border"></span> </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="phone">Primary Contact Number<span class="text-danger"> *</span></label>
                            <input type="text" id="phone" name="phone" class="form-control effect-1" aria-describedby="emailHelp" value ="{{ $customer->phone }}">
                            <span class="focus-border"></span> </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="alternate_phone">Secondary Contact Number</label>
                            <input type="text" id="alternate_phone" name="alternate_phone" class="form-control effect-1" aria-describedby="emailHelp" value ="{{ $customer->alternate_phone }}">
                            <span class="focus-border"></span> </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="pin">PIN<span class="text-danger"> *</span></label>
                            <input type="text" class="form-control effect-1" aria-describedby="emailHelp" id="pin" name="pin" value ="{{ $customer->pin }}" placeholder="XXXX">
                            <span class="focus-border"></span> </div>
                        <div class="form-group col-sm-12 col-md-6"> </div>
                        <div class="form-group col-sm-12 col-md-6"> </div>
                        <div class="form-group col-sm-12 col-md-6 text-right">
                            <button type="submit" class="btn lightbtn"><span class="fas fa-save"></span>Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- addnotes -->
<div class="row addnotes">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <a class="add-note-btn" href="#note"><h1><span class="add-note" ><img src="{{ asset('theme/img/add_note.png') }}" alt="" width="59" height="59"></span>Add A Note</h1></a>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="notesbxnew2 active" id="note">
            <div class="col-sm-12 col-md-12 customer-note-form notesbxnew2_new display-none">
                <div class="row">
                    <div class="form-group col-sm-12 col-md-12 notesnewtxtfld">
                        <label for="exampleInputEmail1"></label>
                        <div class="row">
                            <div class="col-sm-12 col-md-8">
                                <input type="text" class="form-control effect-1 customer-note" aria-describedby="Text" placeholder="Enter Text">
                                <span class="focus-border"></span>
                                <p class="error-msg note-error display-none">*Please Enter Note</p>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <button type="button" class="btn lightbtn save-customer">Save Note</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            @isset($customer->customerNote[0])
            <div class="col-sm-12 col-md-12 col-lg-12 notesbxnew3_new customer_note">
            @else
            <div class="col-sm-12 col-md-12 col-lg-12 notesbxnew3_new customer_note display-none-imp">
            @endisset
                <div class="addnotetblenew">
                    <div class="table-responsive">
                        <table class="table customer-notes-table">
                            <thead>
                                <tr>
                                    <th scope="col" class="custom-name-width">By</th>
                                    <th scope="col" class="custom-date-width">Date</th>
                                    <th scope="col">Note</th>
                                </tr>
                            </thead>
                            <tbody class="customer-card">
                                <tr></tr>
                                @foreach($customer->customerNote as $note)
                                    <tr>
                                        @isset($note['staff']['id'])
                                        <td>
                                            <div class="usrimg"><img src="{{ $note['staff']['admin_image'] }}" alt="" width="25" height="25"></div>
                                            <strong>{{ $note['staff']['full_name'] }}</strong>
                                        </td>
                                        @else
                                        <td>
                                            <div class="usrimg"><img src="{{ asset('theme/img/profile_pic.png') }}" alt="" width="25" height="25"></div>
                                            <strong>Customer</strong>
                                        </td>
                                        @endif
                                        <td>{{ $note['created_date_formatted'] }}</td>
                                        <td>{{ $note['text'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('validate-js')
    
@endsection

@push('js')
{!! Html::script('js/vendors/selectize.min.js') !!}
<script>
    $(function(){

        let tabIndex = {{ isset($_GET['tab_index']) ? $_GET['tab_index']: '0' }}
        $('.nav-item').eq(tabIndex).find('a').click();

        $('.save-customer').on('click', addNoteAjax);

        function addNoteAjax() {
            let note = $('.customer-note').val();
            if(note == "") {
                $('.note-error').removeClass('display-none');
            }else{
                formData = {
                    text: note,
                    pin: $('.note-checkbox').is(':checked') ? 1 : 0,
                };
                $.ajax({
                    type: 'POST',
                    url: '{{ route('add.customer.note', $customer->id) }}',
                    dataType: 'json',
                    data:formData,
                    beforeSend: showLoader,
                    success: function (data) {
                        $('.customer-note-form').addClass('display-none');
                        $('.customer_note').removeClass("display-none-imp");
                        $('.customer-card tr').first().before('<tr><td><div class="usrimg"><img src="{{ asset('theme/img/profile_pic.png') }}" alt="" width="25" height="25"></div><strong>{{ Auth::user()->full_name }}</strong></td><td>'+data.date+'</td><td>'+data.text+'</td></tr>')

                    },
                    complete: hideLoader,
                    error: function (xhr,status,error) {
                        firstXhrError(xhr);
                    }
                });
            }
        }

        $('#phone, #alternate_phone').mask('000-000-0000', {
            'translation': {
                0: {
                    pattern: /[0-9*]/
                }
            }
        });

        $('body').on('submit', '#customer-detail-form', function(f) {
            f.preventDefault();
            fieldValidate(f);
            if ($('#customer-detail-form').valid()) {
                editCustomerAjax();
            }
        });
        $('body').on('click', '.add-note-btn', function(f) {
            $('.customer-note-form').toggleClass('display-none');
        });

        function editCustomerAjax(e) {
            const loginForm = $("#customer-detail-form");
            const formData = loginForm.serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('update.customer') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    $('.update-customer-close-btn').click();
                    if (data.company_name == null) {
                        $('.fullname').html('<h1 class="fullname">'+data.fname+" "+data.lname +'<p class="float-right paddind-r-5"> </p></h1>');
                    } else {
                        $('.fullname').html('<h1 class="fullname">'+data.fname+" "+data.lname +'<p class="float-right paddind-r-5">'+data.company_name+'</p></h1>');

                    }
                    $('.email').html('<a class="email" href="mailto:'+data.email+'"><span class="fas fa-envelope-open"></span>'+data.email+'</a>');
                    $('.customer-phone').text(data.phone);
                    $('.customer-pin').text(data.pin);
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        };

        function fieldValidate(f){
            f.preventDefault();
            let e = $(this);
            $('#customer-detail-form').validate({
                rules: {
                    fname: {
                        required:  true,  
                    },
                    lname: {
                        required:  true,
                    },
                    pin: {
                        required:   true,
                        minlength:  4,
                        maxlength:  4,   
                    },
                    phone: {
                        required:   true,
                        minlength:  12,
                    },
                    alternate_phone: {
                        minlength:  12,
                    },
                    email:{
                        required:  true,
                        email:     true,
                        remote :{
                            url: "{{ route('check.email', $customer->id) }}",
                            type: "post"
                        }
                    },
                },
                messages: {
                    email: {
                        required: "Please enter your email address",
                        email:    "Please enter a valid email address",
                        remote:   "Email id already exist"
                    },
                    phone: {
                        required:    "Please enter your Phone Number",
                        minlength:   "Phone Number must be of 10 digit"
                    },
                    alternate_phone: {
                        minlength:   "Phone Number must be of 10 digit"
                    },            
                },

                errorElement: "em",

                errorPlacement: function( error, element ){
                    $(element).addClass('is-invalid');
                    error.addClass('form-text text-muted text-danger');
                    error.insertAfter(element);
                },
                success: function( label, element ){
                    $(element).removeClass("is-invalid");
                },
            });
        }

        function loadSubscriptionCloseData() {
        $('#subscription-close-table').DataTable({
            "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
            "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "info": true,
            "bDestroy": true,
            "ajax": {
            "url": "{{ URL::route('customer.subscription.datatables', $customer->id) }}",
                beforeSend: showLoader,
                complete: hideLoader,
                "data": function ( d ) {
                    d.isClose = true;
                }
            },
            "language": {
                "processing": "Please Wait...",
            },
            "columns": [
                
                { "data": 'phone-no' },
                { "data": 'ban' },
                { "data": 'label' },
                { "data": 'sim-num' },
                { "data": 'plans' },
                { "data": 'add-ons' },
                { "data": 'port-number' },
                { "data": 'activation-date' },
                { "data": 'status' },
                { "data": 'action' },
                {
                    "class": "display-none data-id",
                    "data" : 'id'
                },
            ]
        });
    }
    });

    $(document).ready(function() {
        $('#activenumber').mask('000-000-0000', {
            'translation': {
                0: {
                    pattern: /[0-9*]/
                }
            }
        });
        $('#simnumber').mask('000-000-000-000-000-0000', {
            'translation': {
                0: {
                    pattern: /[0-9*]/
                }
            }
        });
        $('#imei').mask('000-000-000-000-000', {
            'translation': {
                0: {
                    pattern: /[0-9*]/
                }
            }
        });
    

        $('.type').css('pointer-events', 'none');
        $('.type').css('opacity', '0.6');

        $("#exampleFormControlSelect5").change(function() {
            if ($(this).val() == "Credit") {
                $('.visacard').css('pointer-events', 'none');
                $('.visacard').css('opacity', '0.6');
                $('.type').css('pointer-events', 'none');
                $('.type').css('opacity', '0.6');
            } else if ($(this).val() == "Custom Invoice") {
                $('.visacard').css('pointer-events', 'none');
                $('.visacard').css('opacity', '0.6');
                $('.type').css('pointer-events', 'auto');
                $('.type').css('opacity', '1');
            } else if ($(this).val() == "Custom Charge") {
                $('.type').css('pointer-events', 'auto');
                $('.type').css('opacity', '1');
                $('.visacard').css('pointer-events', 'auto');
                $('.visacard').css('opacity', '1');
            } else {
                $('.visacard').css('pointer-events', 'auto');
                $('.visacard').css('opacity', '1');
                $('.type').css('pointer-events', 'none');
                $('.type').css('opacity', '0.6');
            }
        });

    });

</script>
@endpush