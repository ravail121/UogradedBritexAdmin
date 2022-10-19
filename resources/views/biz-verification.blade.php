@extends('layouts._app-auth')

@push('css')
<style>  
.swal-footer {
  text-align: center;
}
</style>
@endpush

@section('loader-image')
    <div class="my-overlay"></div>
    <div class="loading-gif">
        <img src="{{ asset('theme/img/loader.gif') }}" />
    </div>
@endsection

@section('page-title')
    Business Queue
@endsection

@section('content')
<!-- Table Data -->
<div class="container-fluid">
<div class="tabsdata mt-5">
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="tabstable">
    <div class="subscbx bc">
        <div class="subsctblehdr">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                   <h1><span><img src="theme/img/active_img.png" width="11" height="11" alt=""/></span>Business Verification Requests</h1>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                   <div class="btns">
                      <div class="dropdown filterbtnout">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="fas fa-filter"></span>Filter 
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton1">
                            {!! Form::hidden(null, $details->type, ['class' => 'type-field']) !!}
                            <a class="dropdown-item pending" href="?type=0">Pending</a>
                            <a class="dropdown-item all" href="?type=2">All</a>
                            <a class="dropdown-item rejected" href=?type=-1>Rejected</a>
                            <a class="dropdown-item accepted" href= "?type=1">Accepted</a>
                        </div>
                      </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
    <div class="subscribersdata business">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Email</th>
                        <th scope="col">Name</th>
                        <th scope="col">Action </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $key => $bizVerification)
                        <tr class= "display">
                            <td></td>
                            <td>{{ $bizVerification->created_at_formatted }}</td>
                            @if($bizVerification->approved == 0)
                                <td><span class="activest smorng">Pending</span></td>
                            @elseif($bizVerification->approved == 1)
                                <td><span class="activest smgreen">Accepted</span></td>
                            @else
                                <td><span class="activest smipink">Rejected</span></td>
                            @endif
                             {!! Form::hidden('approved', $bizVerification->approved ) !!}
                            <td>{{ $bizVerification->email }}</td>
                            <td>{{ $bizVerification->fname }} {{ $bizVerification->lame }}</td>
                            <td>
                            <div class="actions">
                               <button type="button" class="btn btn-dark morebtn view-btn"  href="#businessm" role="button" aria-expanded="false" aria-controls="collapseExample">View <span class="fas fa-angle-right"></span></button>
                            </div>
                            </td>
                        </tr>
                        <tr id="businessm" class="collapse display fade display-none">
                            <td colspan="6" class="morebuttonopen">
                                <div class="tbcdataout">
                                <div class="table-responsive">
                                <div class="tbcdata">
                                <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="verificationpage">
                                    <div class="verihdr">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12">
                                                <!-- <a href="#" class="normaltxtbtn float-left"><span class="fas fa-arrow-left"></span>Back To List</a> -->
                                                @if($bizVerification->is_approved)
                                                    <button type="button" class="roundedbtnsmborded grybtn float-right ml-2 cross" aria-label="Close">
                                                    &nbsp;X&nbsp;
                                                    </button>
                                                    <a href="#" data-hash="{{ $bizVerification->hash }}" class="roundedbtnsmborded purplebtnn btnlrge float-right accept-btn">Accept</a>
                    
                                                    <a href="#rejectpopup" class="roundedbtnsmborded grybtn float-right mr-2 add-msg-reject">Add Message &amp; Reject</a>
                                                @else
                                                    <a href="#" class="roundedbtnsmborded purplebtnn btnlrge float-right pending-btn"  data-hash="{{ $bizVerification->hash }}">Move To Pending</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="verimain">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="veritbletxt">
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>First Name :</strong></td>
                                                                <td>{{ $bizVerification->fname }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Last Name :</strong></td>
                                                                <td>{{ $bizVerification->lname }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Email :</strong></td>
                                                                <td>{{ $bizVerification->email }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>DBA :</strong></td>
                                                                <td>{{ $bizVerification->business_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>TAX :</strong></td>
                                                                <td>{{ $bizVerification->tax_id }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        @if(!$bizVerification->businessVerificationDoc->count())
                                            <div class="col-sm-12 col-md-8 col-lg-8">
                                               <div class="veritxt">
                                                  <p> Document:User didn’t upload any document file.</p>
                                               </div>
                                            </div>
                                        @else
                                            <div class="col-sm-12 col-md-8 col-lg-8">
                                               <div class="veritxt">
                                                
                                               </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4">
                                                <div class="veribtns">
                                                    <button type="button" class="roundedbtnsmborded purplebtnn mr-2"><span class="fas fa-file-alt"></span>{{ $bizVerification->businessVerificationDoc->count() }}  Attachment</button>
                                                    <a class='biz-download-btn' href ={{ route('zip', $bizVerification->id) }}><span class="fas fa-cloud-download-alt"></span>Download</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="veriseprator"></div>
                                        <div class="veridoc">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                    <div class="veridocument">
                                                    @foreach($bizVerification->businessVerificationDoc as $key => $image)
                                                    @if($image['url']['type'] == 'image')
                                                        <br>
                                                        <a href="#" class="open-image-btn" data-toggle="modal" data-target="#myModal" img-url={{ $siteUrlLocation }}{{ $image['url']['image'] }}>View in Modal</a>
                                                        <iframe src="iframe-image?src={{ $siteUrlLocation }}{{ $image['url']['image'] }}" class="iframe-image"></iframe>
                                                    @elseif($image['url']['type'] == 'pdf')
                                                       <iframe src="{{ $siteUrlLocation }}{{ $image['url']['image'] }}" class="iframe-image"></iframe>
                                                    @else 
                                                        <a href = {{ route('download.doc', $image['url']['file']) }}>
                                                        <img class="sample" src="{{ $siteUrlLocation }}{{ $image['url']['image'] }}" alt=""></a>
                                                    @endif
                                                    @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                            </td>
                        </tr>
                        <!-- Reject Popup Message Popup Model modal -->
                        @if($bizVerification->is_approved)
                            <tr class ="display-none">
                                <td>
                                    <div class="modal fade bd-example-modal-lg reject-popup" id="rejectpopup" tabindex="-1" role="dialog" aria-labelledby="rejectpopup" aria-hidden="true" style="display: block; padding-right: 10px;">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content editpopcontent">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12">
                                                        <div class="topbx redbg" style="margin:0 0 40px 0;">
                                                            <h1>Reject Verification</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="popvtmcont">
                                                    {!! Form::open(['route' => 'reject.business', 'class' => 'login-form rejectBusiness']) !!}
                                                        <div class="row">
                                                            <div class="form-group col-sm-12 col-md-6">
                                                                {!! Form::label('email') !!}
                                                                {!! Form::text('email', $bizVerification->email, ['placeholder' => $bizVerification->email , 'class' => 'form-control effect-1', 'disabled']) !!}
                                                               <span class="focus-border"></span>
                                                            </div>
                                                            {!! Form::hidden(null, $bizVerification->hash, ['name' => 'hash', 'id' => 'hash']) !!}
                                                            <div class="form-group col-sm-12 col-md-6">
                                                                {!! Form::label('responses') !!}
                                                                <select class="custom-select effect-1 cannedResponse" id="exampleFormControlSelect99199" name='canned_response_id'>
                                                                <option value="" disabled selected data-body="">Please Select</option>
                                                                @foreach($cannedResponse as $canned)
                                                                    <!-- <option class="usflag">Please Select</option> -->
                                                                    <option value="{{ $canned['id'] }}" data-body="{{ $canned['body'] }}" data-subject="{{ $canned['subject'] }}" >{{ $canned['name'] }}</option>
                                                                @endforeach
                                                                </select>
                                                                                    
                                                                <span class="focus-border"></span>
                                                            </div>
                                                            <div class="form-group col-sm-12 col-md-12 textarean">
                                                                {!! Form::label('Subject') !!}
                                                                {!! Form::text('subject', null , ['class' => 'form-control textaream mail-subject effect-1', 'placeholder' => 'Subject']) !!}
                                                                <span class="focus-border"></span>
                                                            </div>
                                                            <div class="form-group col-sm-12 col-md-12 textarean">
                                                                {!! Form::label('Additional message to send with the email:') !!}
                                                                {!! Form::textarea('message', null , ['class' => 'form-control textaream additional-message effect-1', 'rows' => '3',  'placeholder' => 'Additional Info..']) !!}
                                                                <span class="focus-border"></span>
                                                            </div>
                                                            <div class="form-group col-sm-12 col-md-12 text-right">
                                                                {!! Form::button('Confirm Reject',['class' => 'btn lightbtn reject-btn', 'type' => 'submit']) !!}
                                                            </div>
                                                        </div>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <nav aria-label="Page navigation example" class="mypagination">
                    {!! $details->appends(Illuminate\Support\Facades\Input::except('page'))->links() !!}
                </nav>
            </div>
        </div>

    </div>
</div>
</div>
</div>
</div>
</div>
<div class="background"></div>
<!--Custom Popup Image Modal -->
<div class="container">
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="image-modal-body modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
$(function() {
   
    $('body').on('change', '.cannedResponse', function(){
        $('.mail-subject').val($(this).find(':selected').attr('data-subject'));
        $('.additional-message').val($(this).find(':selected').attr('data-body'));
    });

    let type = $('.type-field').val();
    if(type == 0){
        const $pending = $('.pending');
        $pending.addClass('active');
        $pending.append('<span class="fas fa-check float-right"></span>');
    }else if(type == 1){
        const $accepted = $('.accepted');
        $accepted.addClass('active');
        $accepted.append('<span class="fas fa-check float-right"></span>');
    }else if(type == -1){
        const $rejected = $('.rejected');
        $rejected.addClass('active');
        $rejected.append('<span class="fas fa-check float-right"></span>');
    }else{
        const $all = $('.all');
        $all.addClass('active');
        $all.append('<span class="fas fa-check float-right"></span>');
    }

    $('.view-btn').on('click',function(f){
        f.preventDefault();
        const  $this = $(this);
        $this.parents('tr').next('tr').toggleClass('display-none show');
        if($this.find('svg').attr('data-icon') == "angle-right") {            
            $this.find('svg').attr('data-icon', 'angle-down');
        } else {
            $this.find('svg').attr('data-icon', 'angle-right');
        }
    });

    $('.cross').on('click',function(f){
        f.preventDefault();
        const  $this = $(this);
        $this.parents('tr').toggleClass('display-none show');
        $('svg[data-icon="angle-down"]').attr('data-icon', 'angle-right');
    });

    $('.open-image-btn').on('click', function() {
        $('.image-modal-body').html('<img src='+$(this).attr('img-url')+'>')
    })

    // $('.dropdown-item').on('click', options);

    function options(f)
    {
        f.preventDefault();
        const  $this = $(this);
        $('.display').addClass('display-none');
        $('.dropdown-item').removeClass('active');
        $('.dropdown-item svg').remove(),
        $this.addClass('active'),
        $this.append('<span class="fas fa-check float-right"></span>');
        let option = $this.text();
        if(option == 'All'){
            $('.display').removeClass('display-none');
        }
        else if(option == 'Pending'){
            let input = $("input[value='0']").parents('tr');
            input.removeClass('display-none'),
            input.next('tr').removeClass('display-none');
        }
        else if(option == 'Rejected'){
            let input = $("input[value='-1']").parents('tr');
            input.removeClass('display-none'),
            input.next('tr').removeClass('display-none');
        }
        else if(option == 'Accepted'){
            let input = $("input[value='1']").parents('tr');
            input.removeClass('display-none'),
            input.next('tr').removeClass('display-none');
        }
    }

    $('.accept-btn').on('click', accept);

    function accept(e) {
        e.preventDefault();
        swal({
            title: "Approve Business?",
            text: "",
            icon: "warning",
            buttons: [true, "Yes"],
        })
        .then((willDelete) => {
            if (willDelete) {
                runAjax('approved', 'Business Verification Approved Successfully', $(this).attr('data-hash'))
            }
        });
    }

    $('.pending-btn').on('click', pending);

    function pending(e) {
        e.preventDefault();
        swal({
            title: "Move to Pending List?",
            text: "",
            icon: "warning",
            buttons: [true, "Yes"],
        })
        .then((willDelete) => {
            if (willDelete) {
                runAjax('pending', 'Business moved to Pending', $(this).attr('data-hash'))
            }
        });
    }

    function runAjax(status, response, hash) {
        const formData = {status: status,
            hash: hash};
        $.ajax({
            type: 'POST',
            url: '{{ route('change.status') }}',

            dataType: 'json',
            data:formData,
            beforeSend: showLoader,
            success: function (data) {
               swal(response)
                .then((value) => {
                    location.reload();
                });
            },
            complete: hideLoader,
            error: function (xhr,status,error) {
                firstXhrError(xhr);
            }
        });
    }

    $('.close').on('click', function(){
        const $parentsTr = $(this).parents('tr');
        $('.background').removeClass('background-show');
        $parentsTr.children('td').children('.reject-popup').toggleClass('show');
        $parentsTr.toggleClass('display-none');
    });

    $('.reject-btn').on('click', showLoader);
    $('.add-msg-reject').on('click', showPopup);

    function showPopup(e) {
        e.preventDefault();
        const $nextTr =  $(this).parents('tr').next('tr');
        $nextTr.toggleClass('display-none');
        $nextTr.children('td').children('.reject-popup').toggleClass('show');
        $('.background').addClass('background-show');
    }
    hideLoader();
});
</script>
@endpush
      