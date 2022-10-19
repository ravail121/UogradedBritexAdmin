@extends('layouts._app-auth')

@section('page-title')
   Ban
@endsection

@section('content')
<div class="subscbx bgwhite">
    <div class="subsctblehdr">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-10">
                <h1><span><img src="{{ asset("theme/img/active_img.png") }}" width="11" height="11" alt=""/></span>All Ban</h1>
            </div>

            <div class="col-sm-12 col-md-2 col-lg-2">
                <div class="actionbtn"> 
                    <a class="btn markbtn createbtn check-carrier" href="#createpopup" data-toggle="modal" data-target="#createpopup">Add New Ban</a> 
                </div>
            </div>
        </div>
    </div>
    <div class="subscribersdata">
        <div class="table-responsive">
            <table class="table audittable tablecentertxt ban-table-class" id="table">
                <thead>
                    <tr>
                        <th scope="col" class="width-7">Carrier</th>
                        <th scope="col" class="">Created Date</th>
                        <th scope="col" class="">Rate Plan</th>
                        <th scope="col">Account No.</th>
                        <th scope="col">Billing Start Date</th>
                        <th scope="col">Voice Subscription</th>
                        <th scope="col">Voice Limit</th>
                        <th scope="col">Voice Avaliable</th>
                        <th scope="col">Data Subscription</th>
                        <th scope="col">Total Subscription</th>
                        <th scope="col" class="display-none"></th>
                        <th scope="col" class="display-none"></th>
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
                        <h1>Add New Ban</h1>
                    </div>
                </div>
            </div>
            <div class="popvtmcont carrier-name">
               
            </div>
            <div class="popvtmcont select-node ">
                
            </div>
            <div class="popvtmcont create-node display-none">
                <h4 class="margin-botton-50">Create Node</h4>
                <form id ="add-node-form"  method="post">
                    <input type="text" name="node-number" id="node-number" class="form-control" placeholder="Enter Node Number" required="true" number="true" >
                    <br><br>
                    <button type="submit" class="btn submit-node-btn lightbtn2">Create Node</button>'
                </form>
            </div>

            <div class="popvtmcont create-fan display-none">
                <h4 class="margin-botton-50">Create Fan</h4>
                <form id ="add-fan-form"  method="post">
                    <input type="text" name="fan-number" id="fan-number" class="form-control" placeholder="Enter Fan Number" required="true" number="true" >
                    <br><br>
                    <button type="submit" class="btn submit-fan-btn lightbtn2">Create Fan</button>'
                </form>

            </div>
            <div class="popvtmcont add-ban-form display-none">
                <h4 class="">BAN Details</h4>
                <form id ="add-ban-form"  method="post">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-12 text-center mt-3">

                            <input type="hidden" name="carrier_id" id="carrier_id">

                            <input type="hidden" name="fan_id" id="fan_id">

                            <input type="hidden" name="node_id" id="node_id">

                            <input type="text" name="name" id="name" class="ban-form margin-botton-20" placeholder="Rate Plan (Name)*" required="true" >

                            <input type="text" name="number" id="number" class="ban-form margin-botton-20" placeholder="Number*" required="true" number="true" >

                            <input type="number" name="billing_start_day" id="billing_start_day" class="ban-form margin-botton-20 w-100" placeholder="Billing Start Day*" required="true" min="1" max="31">

                            <input type="text" name="voice_limit" id="voice_limit" class="ban-form margin-botton-20" placeholder="Voice Limit" number="true" >

                            <input type="text" name="data_limit" id="data_limit" class="ban-form margin-botton-20" placeholder="Data Limit" number="true" >

                            <input type="text" name="total_limit" id="total_limit" class="ban-form" placeholder="Total Limit" number="true" >
                            <br><br>
                            <button type="submit" class="btn lightbtn2">Create New Ban</button>
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
        // $('.add-ban-form #billing_start_day').datepicker({ 
            // autoclose: true, 
            // todayHighlight: true,
            // format: 'mm/dd/yyyy'
        // }).datepicker();

        loadData();
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
                    url: "{{URL::route('allban.datatable') }}",
                    beforeSend: showLoader,
                    complete: hideLoader,
                },
                "language": {
                    "processing": "Please Wait...",
                },
                "columns": [
                    { 
                        "data": 'carrier',
                        'class' :'text-center',
                    },
                    { 
                        "data": 'created_at',
                        'class' :'text-center',
                    },
                    { 
                        "data": 'name',
                        'class' :'text-center',
                    },
                    { "data": 'number' },
                    { "data": 'billing_start_day' },
                    { "data": 'voice_subscription' },
                    { "data": 'voice_limit' },
                    { "data": 'voice_avaliable' },
                    { "data": 'data_subscription' },
                    { "data": 'total_subscription' },
                    { 
                        "data": 'all-data',
                        "orderable": false,
                        'class' :'display-none data-row',
                    },
                    { 
                        "data": 'id',
                        "orderable": false,
                        'class' :'display-none ban-id',
                    },
                ]
                
            });
        }

        $('body').on('click', '.check-carrier', function() {
            $(this).removeClass('check-carrier');
            $(this).addClass('loaded-carrier');
            checkCarrier();
        }); 

        $('body').on('click', '.loaded-carrier', function() {
            $('.popvtmcont').addClass('display-none');
            if ($('.carrier-name .carrier-box').text() == "") {
                $('.active-tab').removeClass('display-none');
            }else{
                $('.carrier-name').removeClass('display-none');
            }       
        });

        $('body').on('submit', '#add-ban-form', function(e) {
            e.preventDefault();
            createBan();
        });

        $('body').on('click', '.ban-table-class tbody tr', function(e) {
            document.location.href="{{ route('ban.detail') }}"+'/'+$(this).find('.ban-id').text();
        });

        $('body').on('click', '.create-node-btn', function() {
            $('.popvtmcont').addClass('display-none');
            $('.create-node').removeClass('display-none');
        });

        $('body').on('click', '.create-fan-btn', function() {
            $('.popvtmcont').addClass('display-none');
            $('.create-fan').removeClass('display-none');
        });

        $('body').on('click', '.ban-node', function() {
            $('.popvtmcont').addClass('display-none');
            $('.add-ban-form').removeClass('display-none');
            $this = $(this);
            if($this.attr('data-type') =='node'){
                $('#node_id').val($this.attr('data-id'));
                $('#fan_id').val('');
            }else{
                $('#fan_id').val($this.attr('data-id'));
                $('#node_id').val('');
            }
        });

        $('body').on('submit', '#add-node-form', function(e) {
            e.preventDefault();
            insertNode()
        });

        $('body').on('submit', '#add-fan-form', function(e) {
            e.preventDefault();
            insertFan()
        });


        $('body').on('click', '.carrier-box', function() {
            $('.popvtmcont').addClass('display-none');
            $('.select-node').removeClass('display-none');
            $('.add-ban-form #carrier_id').val($(this).attr('data-id'));
            let slug = $(this).attr('data-slug');
            if(slug == "t-mobile"){
                allNode();
            }else if(slug == "at&t"){
                allFan();
            }else{
                $('.popvtmcont').addClass('display-none');
                $('.add-ban-form').removeClass('display-none');
                $('#fan_id').val('');
                $('#node_id').val('');
            }
        });

        function createBan() {
            let formData = $('#add-ban-form').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('create.ban') }}',
                dataType: 'json',
                data:formData,
                beforeSend: showLoader,
                success: function (data) {
                    swal("Success!",'Ban Sucessfully Created!' , "success");
                        $('.close').click();
                        $('#add-ban-form input').val('');
                        loadData();  
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }

        function checkCarrier() {
            $.ajax({
                type: 'POST',
                url: '{{ route('check.carrier', auth()->user()->company_id ) }}',
                dataType: 'json',
                beforeSend: showLoader,
                success: function (data) {
                    if(data.carrier.length > 1){
                        let carrierhtml = '<div class="row">';
                        data.carrier.forEach(function(element) {
                            carrierhtml +='<div class="carrier-box" data-id='+element.id+' data-slug='+element.slug+'><h1>'+element.name+'</h1></div>'; 
                        });
                        carrierhtml += '</div>';
                        $('.carrier-name').html(carrierhtml);
                        $('.active-tab').removeClass('active-tab');
                        
                    }else{
                        if(data.carrier[0].slug=="t-mobile"){
                            $("#carrier_id").val(data.carrier[0].id);
                            allNode();
                        }else if(data.carrier[0].slug=="at&t"){
                            $("#carrier_id").val(data.carrier[0].id);
                            allFan();
                        }else{
                            $('.popvtmcont').addClass('display-none');
                            $('.add-ban-form').removeClass('display-none');
                            $('#fan_id').val('');
                            $('#node_id').val('');
                        }
                    }
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        };

        function allNode() {
            $.ajax({
                type: 'POST',
                url: '{{ route('all.node') }}',
                dataType: 'json',
                beforeSend: showLoader,
                success: function (data) {
                    node = '<h4>SELECT NODE</h4><div class="row">';
                    data.forEach(function(element) {
                        node +='<div class="col-sm-8 col-md-8 ban-node" data-type ="node" data-id='+element.id+'><h3>'+element.number+'</h3></div>'; 
                    });
                    node += '</div><button type="button" class="btn create-node-btn lightbtn2">Create Node</button>';
                    $('.select-node').html(node);
                    $('.select-node').addClass('active-tab');
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        };

        function allFan() {
            $.ajax({
                type: 'POST',
                url: '{{ route('all.fan') }}',
                dataType: 'json',
                beforeSend: showLoader,
                success: function (data) {
                    node = '<h4>SELECT FAN</h4><div class="row">';
                    data.forEach(function(element) {
                        node +='<div class="col-sm-8 col-md-8 ban-node" data-type ="fan" data-id='+element.id+'><h3>'+element.number+'</h3></div>'; 
                    });
                    node += '</div><button type="button" class="btn  create-fan-btn lightbtn2">Create Fan</button>';
                    $('.select-node').html(node);
                    $('.select-node').addClass('active-tab');
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        };

        function insertNode() {
            const number = $('#node-number').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('create.node') }}',
                dataType: 'json',
                data: {number : number},
                beforeSend: showLoader,
                success: function (data) {
                    allNode();
                    $('.popvtmcont').addClass('display-none');
                    $('.select-node').removeClass('display-none');
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }


        function insertFan() {
            const number = $('#fan-number').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('create.fan') }}',
                dataType: 'json',
                data: {number : number},
                beforeSend: showLoader,
                success: function (data) {
                    allFan();
                    $('.popvtmcont').addClass('display-none');
                    $('.select-node').removeClass('display-none');
                },
                complete: hideLoader,
                error: function (xhr,status,error) {
                    firstXhrError(xhr);
                }
            });
        }
    });
</script>
@endpush