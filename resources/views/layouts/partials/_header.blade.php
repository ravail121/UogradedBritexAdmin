<div class="container-fluid srchcontent">
  <div class="row">
    <div class="col-sm-12 col-md-12">
      <div class="search">
        <div class="input-group">
          <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupPrepend3"><img src = "{{ asset("theme/img/search_icon.png") }}" width="12" height="12" alt=""/></span> </div>
          <input type="text" class="form-control" id="validationDefaultUsername2" placeholder="Search Teltik" aria-describedby="inputGroupPrepend4" required>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-12">
      <div class="slidemenu">
        <ul class="hover-left inline sideoverly2">
          <!--<li><i class="fa fa-chevron-left test" aria-hidden="true"></i></li>-->
        </ul>
        <ul class="week_container">
          {{-- <li class="active"><a href="#">All</a></li> --}}
          <li><a href="javascript:void(0);" class="searchPhone1">Phone</a></li>
          <li><a href="javascript:void(0);" class="searchName1">Name</a></li>
          <li><a href="javascript:void(0);" class="searchSIM1">SIM</a></li>
          <li><a href="javascript:void(0);" class="searchCompany1">Company</a></li>
          {{-- <li><a href="#">Sim Card</a></li>
          <li><a href="#">Order No.</a></li> --}}
        </ul>
        <ul class="hover-right sideoverly">
          <!--<li><i class="fa fa-chevron-right" aria-hidden="true"></i></li>-->
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  <!-- Top hdr -->
  <div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6 align-self-center">
      <nav aria-label="breadcrumb">
        <button type="button" id="sidebarCollapse" class="btn togglebtn d-inline-flex"> <i class="fas fa-bars"></i> </button>
        <ol class="breadcrumb d-inline-flex">
          <li class="breadcrumb-item"><a href="javascript:void(0);" title="Dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page"> @yield('page-title')</li>
        </ol>
      </nav>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
      <div class="userbx">
        <div class="dropdown">
          <button class="btn dropdown-toggle flex-shrink-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="userimg"> <img src= "{{ asset("theme/img/profile_pic.png") }}" width="51" height="51" alt=""/> </div>
            <div class="usertxt">
              <h2>{{ Auth()->user()->fullname }}</h2>
              {{-- <p>CSR Manager</p> --}}
            </div>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault(); localStorage.clear();
                             document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(session('status'))
    <center class="status-alert">{{ session('status') }}</center>
{{ session(['status' => null ])}}
@endif