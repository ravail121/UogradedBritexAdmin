@extends('layouts._app-auth')

@section('page-title')
   BanGroup Detail
@endsection

@section('content')
<div class="subscbx">
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="bgwhite custom-div">  
                <p>Date Created<span>{{ $banGroup->created_at_formatted }}</span></p>
                <p>Group Plan<span>{{ $banGroup->name }}</span></p>
                <p>Billing Start Day<span>0</span></p>
                <p>Group No.<span>{{ $banGroup->number }}</span></p>
                <p>Data Sold<span>0</span></p>
            </div>
            <a class="edit-ban" href="#createpopup" data-toggle="modal" data-target="#createpopup"><i class="fas fa-pencil-alt"></i> Edit Ban Group</a>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4 bgwhite custom-div">
            <p>Data Used<span>0</span></p>
            <p>Date Cap<span>{{ $banGroup->data_cap }}</span></p>
            <p>Remaining<span>0</span></p>
            <p>Lines in Group<span>0</span></p>
            <p>Line Limit<span>{{ $banGroup->line_limit }}</span></p>
            <p>Available<span>0</span></p>
        </div>
    </div>
</div>

<div class="subscbx bgwhite">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h1><span><img src="{{ asset("theme/img/active_img.png") }}" width="11" height="11" alt=""/></span>Subcription</h1>
            </div>
        </div>
    </div>
    

    <div class="subscribersdata">
        <div class="table-responsive">
            <table class="table audittable tablecentertxt" id="table">
                <thead>
                    <tr>
                        <th scope="col" class="custom-name">Customer</th>
                        <th scope="col" class="">Active Phone No.</th>
                        <th scope="col">Address</th>
                        <th scope="col">Plan Type</th>
                        <th scope="col">Plan Name</th>
                        <th scope="col">Sim Card</th>
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
                        <h1>Edit Ban Group</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont">
                <form id ="edit-ban-group"  method="post">
                    <input type="hidden" name="id" id="id" value = "{{ $banGroup->id }}" required="true" >
                    <div class="row">

                        <div class="form-group col-sm-6 col-md-6">
                            <label>Name<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="name" id="name" class="ban-form margin-botton-20" placeholder="Voice Limit" required="true" value = "{{ $banGroup->name }}">
                        </div>

                        <div class="form-group col-sm-6 col-md-6">
                            <label>Number<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="number" id="number" class="ban-form margin-botton-20" placeholder="Number" required="true"  value = "{{ $banGroup->number }}">
                        </div>

                        <div class="form-group col-sm-6 col-md-6">
                            <label>Ban<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            {{ Form::select('ban_id',$ban,  $banGroup->ban_id , ['id' => 'type', 'class' => 'width-100']) }}
                        </div>

                        <div class="form-group col-sm-6 col-md-6">
                            <label>Data Capacity<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="data_cap" id="data_cap" class="ban-form margin-botton-20" placeholder="Data Capacity" required="true" value = "{{ $banGroup->data_cap }}">
                        </div>

                        <div class="form-group col-sm-6 col-md-6">
                            <label>Line Limit<span class="text-danger"> *</span></label>
                        </div>
                        <div class="form-group col-sm-6 col-md-6">
                            <input type="text" name="line_limit" id="line_limit" class="ban-form margin-botton-20" placeholder="Line Limit" required="true" number="true" value = "{{ $banGroup->line_limit }}">
                        </div>

                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn lightbtn2">Edit Ban Group</button>
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
        loadData();
        function loadData() {
            $('#table').DataTable( {
                "dom": '<"row" <"col-sm-9"l> <"col-sm-3"f>>t<"row" <"col-sm-6"i> <"col-sm-6"p>>',
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "info": true,
                "bDestroy": true,
                "ajax": {
                    "url": "{{URL::route('bangroup.subcription.datatable', $banGroup->id) }}",
                    beforeSend: showLoader,
                    complete: hideLoader,
                },
                "language": {
                    "processing": "Please Wait...",
                },
                "columns": [
                    { "data": 'name' },
                    { 
                        "data": 'phone_number_formatted',
                        "class": "text-center"
                    },
                    { "data": 'address' },
                    { "data": 'plan-type' },
                    { "data": 'plan-name' },
                    { "data": 'sim_card_num' },
                    { "data": 'status' },
                ]
                
            });
        }

        $('body').on('submit', '#edit-ban-group', function(e) {
            e.preventDefault();
            editBanGroup();
        });

        function editBanGroup() {
            let formData = $('#edit-ban-group').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('edit.ban.group') }}',
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

    });
</script>
@endpush