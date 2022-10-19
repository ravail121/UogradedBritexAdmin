@extends('layouts._app-auth')

@section('page-title')
   BanGroup
@endsection

@section('content')
<div class="subscbx">
    <div class="row">
        <input type="hidden" id="ban_type_fan" value="{{ $ban->fan_id }}">
        <input type="hidden" id="ban_type_node" value="{{ $ban->node_id }}">
        <div class="col-sm-12 col-md-6 col-lg-6 bgwhite custom-div">
            <p>Date Created<span>{{ $ban->created_at_formatted }}</span></p>
            <p>Rate Plan<span>{{ $ban->name }}</span></p>
            <p>Billing Start date<span>{{ $ban->billing_start_day }}</span></p>
            <p>Account No.<span>{{ $ban->number }}</span></p>
            <p>Voice Limit<span>{{ $ban->voice_limit }}</span></p>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4">
            <div class="bgwhite custom-div">
                <p>Voice Subscriptions<span>{{ $voiceSubcription }}</span></p>
                <p>Voice Available<span>{{ $voiceAvaliable }}</span></p>
                <p>Data Subscriptions<span>{{ $dataSubcription }}</span></p>
                <p>Total Subscriptions<span>{{ $ban->total_limit }}</span></p>
            </div>
            <a class="edit-ban" href="#createpopup" data-toggle="modal" data-target="#createpopup"><i class="fas fa-pencil-alt"></i> Edit Ban</a>
        </div>
    </div>
</div>

<div class="subscbx bgwhite">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
                <h1><span><img src="{{ asset("theme/img/active_img.png") }}" width="11" height="11" alt=""/></span><span class="table-type"></span></h1>
            </div>

            <div class="col-sm-12 col-md-2 col-lg-2">
                <div class="actionbtn fan_type-btn">
                </div>
            </div>
        </div>
    </div>
    <div class="subscribersdata">
        <div class="table-responsive">
            <table class="table audittable tablecentertxt ban-table-class display-none" id="table">
                <thead>
                    <tr>
                        <th scope="col" class="custom-date-width">Created Date</th>
                        <th scope="col" class="">Group Plan</th>
                        <th scope="col">Group ID</th>
                        <th scope="col">Data Used</th>
                        <th scope="col">Data Sold</th>
                        <th scope="col">Data Cap. (GB)</th>
                        <th scope="col">Line in Group</th>
                        <th scope="col">Line Limit</th>
                        <th scope="col">Remaning</th>
                        <th class="display-none" scope="col"></th>
                    </tr>
                </thead>
            </table>
            <table class="table audittable tablecentertxt node-type-table display-none" id="all-paln-table">
                <thead>
                    <tr>
                        <th scope="col" class="custom-name-width">Name</th>
                        <th scope="col" class="">Active No.</th>
                        <th scope="col">Address</th>
                        <th scope="col">Plan Type</th>
                        <th scope="col">Plan</th>
                        <th scope="col">Addon</th>
                        <th scope="col">Sim Number</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="createpopup" tabindex="-1" role="dialog" aria-labelledby="createpopup" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx purplebg" style="margin:0 0 40px 0;">
                        <h1>Edit Ban</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="edit-ban-form"  method="post">
                    <input type="hidden" name="id" id="id" value = "{{ $ban->id }}" >
                    <div class="row">
                        <div class="form-group col-sm-6 col-md-6">
                            <label>Rate Plan (Name)<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="name" id="name" class="ban-form margin-botton-20" placeholder="Rate Plan (Name)" required="true" value = "{{ $ban->name }}" >
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <label>Number<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="number" id="number" class="ban-form margin-botton-20" placeholder="Number" required="true" value = "{{ $ban->number }}" >
                        </div>
                        <div class="form-group col-sm-6 col-md-6 fan_type">
                            <label>Fan<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6 fan_type">
                            {{ Form::select('type', ['' => '']+ $fan,  $ban->fan_id , ['id' => 'fan_id', 'class' => 'form-control effect-1']) }}
                        </div>

                        <div class="form-group col-sm-6 col-md-6 node_type">
                            <label>Node<span class="text-danger"> *</span></label>
                        </div> 
                        <div class="form-group col-sm-6 col-md-6 node_type">
                            {{ Form::select('type', ['' => '']+ $node,  $ban->node_id , ['id' => 'node_id', 'class' => 'form-control effect-1']) }}
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <label>Billing Start Day<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="billing_start_day" id="billing_start_day" class="ban-form margin-botton-20" placeholder="Billing Start Day" required="true" value = "{{ $ban->billing_start_day }}" >
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <label>Voice Limit</label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="voice_limit" id="voice_limit" class="ban-form margin-botton-20" placeholder="Voice Limit" number="true" value = "{{ $ban->voice_limit }}" >
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <label>Data Limit</label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="data_limit" id="data_limit" class="ban-form margin-botton-20" placeholder="Data Limit"  number="true" value = "{{ $ban->data_limit }}" >
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <label>Total Limit</label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="total_limit" id="total_limit" class="ban-form" placeholder="Total Limit" number="true" value = "{{ $ban->total_limit }}" >
                        </div>

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">Edit Ban</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="createbanpopup" tabindex="-1" role="dialog" aria-labelledby="createbanpopup" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content editpopcontent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="topbx">
                        <h1>Add New Ban Group</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="add-new-ban-group"  method="post">
                    <input type="hidden" name="ban_id" id="ban_id" value = "{{ $ban->id }}" required="true" >
                    <div class="row">

                        <div class="form-group col-sm-6 col-md-6">
                            <label>Ban Group Name<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="name" id="name" class="ban-form margin-botton-20" placeholder="Ban Group Name" required="true" >
                        </div>

                        <div class="form-group col-sm-6 col-md-6">
                            <label>Number<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="number" id="number" class="ban-form margin-botton-20" placeholder="Number" required="true" number="true" >
                        </div>

                        <div class="form-group col-sm-6 col-md-6">
                            <label>Data Capacity<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="data_cap" id="data_cap" class="ban-form margin-botton-20" placeholder="Data Capacity" required="true" number="true" >
                        </div>

                        <div class="form-group col-sm-6 col-md-6">
                            <label>Line Limit<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="line_limit" id="line_limit" class="ban-form margin-botton-20" placeholder="Line Limit" required="true" number="true" >
                        </div>

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">Add Ban Group</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>$('form').each(function(){  $(this).validate(); });</script>
<script>
    $(function(){
        $('#edit-ban-form #billing_start_day').datepicker({ 
            autoclose: true, 
            todayHighlight: true,
            format: 'mm/dd/yyyy'
        }).datepicker();

        let banTypeFan = $('#ban_type_fan').val()
        let banTypeNode = $('#ban_type_node').val()
        if(banTypeFan && banTypeFan !=0){
            $('.table-type').text('Ban Group');
            $('#node_id').prop('disabled', true);
            $('.node_type').addClass('display-none');
            $('.ban-table-class').removeClass('display-none');
            $('.fan_type-btn').html('<a class="btn markbtn createbtn check-carrier" href="#createbanpopup" data-toggle="modal" data-target="#createbanpopup">Add New Ban Group</a>');
            loadData();
        }else{
            $('.table-type').text('Subscription');
            $('.fan_type').addClass('display-none');
            $('#fan_id').prop('disabled', true); 
            $('.node-type-table').removeClass('display-none');
                loadSubcriptionData();
            if(!(banTypeNode && banTypeNode !=0)){
                $('#node_id').prop('disabled', true);
                $('.node_type').addClass('display-none');
            }
        }
        function loadData() {
            $('#table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('ban.detail.datatable', $ban->id) }}",
                    beforeSend: showLoader,
                    complete: hideLoader,
                },
                "language": {
                    "processing": "Please Wait...",
                },
                "columns": [
                    { 
                        "data": 'created_at',
                        'class' :'text-center',
                    },
                    { 
                        "data": 'name',
                        'class' :'text-center',
                    },
                    { "data": 'number' },
                    { "data": 'null' },
                    { "data": 'null' },
                    { "data": 'data_cap' },
                    { "data": 'null' },
                    { "data": 'line_in_group' },
                    { "data": 'line_limit' },
                    { 
                        "data": 'id',
                        "orderable": false,
                        'class' :'display-none ban-group-id',
                    },
                ]                
            });
        }

        function loadSubcriptionData() {
           $('#all-paln-table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "lengthMenu": [[25, 50, 100, 250, 500], [25, 50, 100, 250, 500]],
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('ban.subcription.datatable', $ban->id) }}",
                    beforeSend: showLoader,
                    complete: hideLoader,
                },
                "language": {
                    "processing": "Please Wait...",
                },
                "columns": [
                    { 
                        "data": 'name',
                        'class' :'text-center',
                    },
                    { 
                        "data": 'phone_number_formatted',
                        'class' :'text-center',
                    },
                    { "data": 'address' },
                    { "data": 'plan-type' },
                    { "data": 'plan-name' },
                    { "data": 'addon' },
                    { "data": 'sim_card_num' },
                    { "data": 'status' },
                ]                
            });
        }

        $('body').on('submit', '#edit-ban-form', function(e) {
            e.preventDefault();
            editBan();
        });

        $('body').on('submit', '#add-new-ban-group', function(e) {
            e.preventDefault();
            addBanGroup();
        });

        function addBanGroup() {
            let formData = $('#add-new-ban-group').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('add.ban.group') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    location.reload(true);
                },
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        function editBan() {
            let formData = $('#edit-ban-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('edit.ban') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    location.reload(true);
                },
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        $('body').on('click', '.ban-table-class tbody tr', function(e) {
            document.location.href="{{ route('ban.groups.detail') }}"+'/'+$(this).find('.ban-group-id').text();
        });
    });
</script>
@endpush