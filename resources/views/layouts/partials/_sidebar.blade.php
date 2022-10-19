<nav id="sidebar" class="">
    @if(auth()->user()->company_id != 0)
        <div class="sidebar-header">
            <div class="logo">
                    <br>
                    <span class="logoname"><img src="{{ auth()->user()->company->logo }}" width="180"  alt=""/></span>
            </div>
        </div>

        <div class="search">
            <div class="input-group">
                <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupPrepend2"><img src="{{ asset('theme/img/search_icon.png') }}" width="12" height="12" alt=""/></span> </div>
                <input type="text" class="form-control" id="validationDefaultUsername" placeholder="Search" aria-describedby="inputGroupPrepend2" required>
            </div>
        </div>
        <div class="slidemenu">
            <ul class="hover-left inline sideoverly2">
                <li>
                    <!--<i class="fa fa-chevron-left test" aria-hidden="true"></i>--></li>
            </ul>
            <ul class="week_container">
                <li><a href="#" class="searchPhone">Phone</a></li>
                <li><a href="#" class="searchName">Name</a></li>
                <li><a href="#" class="searchSIM">SIM</a></li>
                <li><a href="#" class="searchCompany">Company</a></li>
            </ul>
            <ul class="hover-right sideoverly">
                <li>
                    <!-- <i class="fa fa-chevron-right" aria-hidden="true"></i>--></li>
            </ul>
        </div>
    @endif
    <ul class="list-unstyled components">
        @if(session('master-admin'))
            <li class="master-admin">
                <p class="master-info">Master Admin</p>
                @if(session('master-staff'))
                    <button class ="master-logout-btn"><a href="{{ route('master-staff-logout') }}">Switch to Master Admin</a></button>
                @endif
                <select name="company" class="custom-select company-dopdown white-color" id="company">
                    @if(! session('master-staff'))
                       <option  value="0" selected>Please select a Company</option>
                    @endif
                   @foreach(session('all-company') as $company)
                        <option value="{{$company->id}}" {{$company->id == auth()->user()->company_id ? 'selected': null }} >{{$company->name}} </option>
                    @endforeach
                </select>
                <i class="fa fa-caret-down white-color" aria-hidden="true"></i>
            </li>
            <li class="{{ setActive('master-admin', 'active') }}">
            <a href={{ route( 'master.admin') }}> <i class="fas fa-building"></i> <span>Companies</span> </a>
        </li>
        @endif
        @if(auth()->user()->company_id != 0)
            {{-- <li>
                <a href="#"> <i class="fas fa-tachometer-alt"></i> <span>
                Dashboard</span> </a>
            </li>
            <li>
                <a href="#customerdetail" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-user-alt"></i> <span>Customer Detail Page</span> </a>
                <ul class="collapse list-unstyled" id="customerdetail">
                    <li> <a href="#">Menu1</a> </li>
                    <li> <a href="#">Menu1</a> </li>
                </ul>
            </li> --}}
            <li class="{{ setActive('action-queue', 'active') }}">
                <a href={{ route( 'action.queue') }}> <i class="fas fa-rocket"></i> <span>Action Queues</span> </a>
            </li>
            <li class="{{ setActive('support', 'active') }}">
                <a href={{ route( 'support.index') }}> <i class="fas fa-question"></i> <span>Support</span> </a>
            </li>
            <li class="{{ setActive('email-template', 'active') }}">
                <a href="#customerdetail" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-envelope"></i> <span>Email Template</span> </a>
                <ul class="collapse list-unstyled" id="customerdetail">
                    <li class="{{ setActive('email-template', 'active') }}"> <a href="{{ route( 'emailTemplate') }}">Email Template</a> </li>
                    <li class="{{ setActive('canned-response', 'active') }}"> <a href="{{ route( 'cannedResponse') }}">Canned Response</a> </li>
                </ul>
            </li>

            @if(auth()->user()->company->business_verification)
                <li class="{{ setActive('biz-verification', 'active') }}">
                    <a href="{{ route('businessVerification') }}" aria-expanded="false"> <i class="fas fa-hourglass-start"></i> <span>Business Verifications</span> <span class="badge badge-light">{{ $unapprovedBusinessVerificationCount }}</span> </a>
                    <ul class="collapse list-unstyled" id="customers">
                        <!-- <li> <a href="#">Menu 1</a> </li> -->
                    </ul>
                </li>
            @endif
            {{-- <li>
                <a href="#customers1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-users-cog"></i> <span>Customers</span> </a>
                <ul class="collapse list-unstyled" id="customers1">
                    <li> <a href="#">Menu 1</a> </li>
                </ul>
            </li> --}}
            <li class="{{ setActive('all', 'active') }}">
                <a href="#products" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-box"></i> <span>Products</span> </a>
                <ul class="collapse list-unstyled" id="products" style="background: none;">
                    <li class="{{ setActive('all-devices', 'active') }}" > <a href="{{ route('all.devices') }}">Devices</a> </li>
                    <li class="{{ setActive('all-plans', 'active') }}" > <a href="{{ route('all.plan') }}">Plans</a> </li>
                    <li class="{{ setActive('all-sims', 'active') }}" > <a href="{{ route('all.sims') }}">Sims</a> </li>
                    <li class="{{ setActive('all-addons', 'active') }}" > <a href="{{ route('all.addons') }}">Add-Ons</a> </li>
                    <li class="{{ setActive('all-replacement-products', 'active') }}" > <a href="{{ route('all-replacement-products') }}">Replacement Products</a> </li>
                </ul>
            </li>
            <li class="{{ setActive('ban', 'active') }}">
                <a href={{ route( 'ban.list') }}> <i class="fas fa-ban"></i> <span>Ban Management</span> </a>
            </li>
            {{-- <li>
                <a href="#webcontent" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-newspaper"></i> <span>Website Content</span> </a>
                <ul class="collapse list-unstyled" id="webcontent">
                    <li> <a href="#">Menu 1</a> </li>
                </ul>
            </li> --}}
            <li class="{{ setActive('coupon', 'active') }}">
                <a href="#order" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-shopping-cart"></i> <span>Order / Cart / Billing</span> </a>
                <ul class="collapse list-unstyled" id="order">
                    <li class="{{ setActive('coupon', 'active') }}"> <a href="{{ route('coupon.index') }}">Coupons</a> </li>
                </ul>
            </li>
            {{-- <li>
                <a href="#outgoingcom" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-headphones"></i> <span>Outgoing Comm.</span> </a>
                <ul class="collapse list-unstyled" id="outgoingcom">
                    <li> <a href="#">Menu 1</a> </li>
                </ul>
            </li> --}}
            {{-- <li>
                <a href="#affilatesys" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-building"></i> <span>Affiliate System</span> </a>
                <ul class="collapse list-unstyled" id="affilatesys">
                    <li> <a href="#">Menu 1</a> </li>
                </ul>
            </li> --}}
            {{-- <li>
                <a href="#reports" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-chart-pie"></i> <span>Reports</span> </a>
                <ul class="collapse list-unstyled" id="reports">
                    <li> <a href="#">Menu 1</a> </li>
                </ul>
            </li> --}}
            <li class="{{ setActive('staff', 'active') }}" >
                <a href="#admin" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-user-circle"></i> <span>Admin</span> </a>
                <ul class="collapse list-unstyled" id="admin">
                    <li class="{{ setActive('staff', 'active') }}">
                        <a href="{{ route('staff.list') }}">Staff Account</a>
                    </li>
                </ul>
            </li>
{{--            <li>--}}
{{--                <a href="/tbc-report"> <i class="fas fa-user-shield"></i> <span>TBC Report</span> </a>--}}
{{--            </li>--}}

            @if (auth()->user()->company->goknows_api_key)
                <li class="{{ setActive('go-know-api', 'active') }}">
                    <a href="{{ route('goknow.index') }}"> <i class="fab fa-simplybuilt"></i> <span>Go Know API</span> </a>
                </li>
            @endif

            @if (env('CRON_TESTING'))
                <li class="{{ setActive('cron-tester', 'active') }}">
                    <a href={{ route('cron.index') }}> <i class="fas fa-tasks"></i> <span>Cron Tester</span> </a>
                </li>
            @endif
            <li class="{{ setActive('email-template', 'active') }}">
                <a href="#tools" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> <i class="fas fa-tools"></i> <span>Tools</span> </a>
                <ul class="collapse list-unstyled" id="tools">
                    <li class="{{ setActive('dueCheck', 'active') }}"> <a href="{{ route( 'dueCheck') }}" title="Due Check">Due Check</a> </li>
                    <li class="{{ setActive('report', 'active') }}"> <a href="{{ route( 'report') }}" title="Report Check">Report Check</a> </li>
                    <li class="{{ setActive('cron-logs', 'active') }}"> <a href="{{ route( 'cron-logs') }}" title="CRON Logs">CRON Logs</a> </li>
                </ul>
            </li>
            
        @endif
    </ul>
</nav>

@push('js')
<script>
    $('.master-admin').on('change','#company', changeCompany);

    function changeCompany(){
        let data = {id: $(this).val()};
        $.ajax({
            type: 'POST',
            url: '{{ route('change.company') }}',
            dataType: 'json',
            data:data,
            beforeSend: showLoader,
            success: function (data) {
                if(data.error){
                    swal("Error!!!", data.error, "error");
                }else{
                swal("Company Changed")
                .then((value) => {
                window.location.href = "{{ route('master.admin') }}";
                });
                }
            },
            complete: hideLoader,
            error: function (xhr,status,error) {
                firstXhrError(xhr);
            }
        });
    }
</script>
@endpush
