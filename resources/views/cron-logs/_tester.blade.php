<div>
    <h3 class='title'></h3>
    <div id="invoice">
        <div>
            <div class="input-group date">
                <strong style='font-size:20px; margin-left: 5px' id='date'></strong>
                <strong style='font-size:20px' id='time'></strong>
                <input style="width:200px" type="text" class="form-control" id='set-date' placeholder='Select date'>
                {{-- <div class="input-group-addon">
                    <span id='select-date' class="glyphicon glyphicon-th"></span>
                </div> --}}
            </div>
            <div style='display:inline-flex;'>
                <div style='margin-top:10px; margin-left: 5px;' class="actionbtn"> 
                    <button id='test-date' class="markshippedbtn confirmaction button-color">Change Date</button> 
                </div>
                <div style='margin-top:10px; margin-left: 5px;' class="actionbtn"> 
                    <button id='reset-date' class="markshippedbtn confirmaction button-color">Reset Date</button> 
                </div>
                <div style='margin-top:10px; margin-left: 5px;' class="actionbtn"> 
                    <button id='restart-apache' class="markshippedbtn confirmaction button-color">Restart Apache</button>
                </div>
                <div style='margin-top:10px; margin-left: 5px;' class="actionbtn"> 
                    <button id='restart-php' class="markshippedbtn confirmaction button-color">Restart Php</button>
                </div>
                <div style='margin-top:10px; margin-left: 5px;' class="actionbtn"> 
                    <button id='clean-cache' class="markshippedbtn confirmaction button-color">Clear Cache</button>
                </div>
                <div style='margin-top:10px; margin-left: 5px;' class="actionbtn"> 
                    <button id='delete-userdata' class="markshippedbtn confirmaction button-color">Delete Userdata</button>
                </div>
               
            </div>
        </div>
    </div>
</div>
        
@push('js')
<script>

    $(function()
    {
        $('#set-date').datetimepicker({
            format:'Y-m-d H:i:s',
            mask: true,
        });
    });

    $(function()
    {
        $.ajax({
            url: '{{ route("cron.get-date") }}',
            method: 'GET',
            dataType: 'json',
            beforeSend: showLoader(),
            complete: hideLoader(),
        }).done(function (response) {
            $('#date').html('Today: ' + response['date']);
            $('#set-date').val(response['date_time']);
            var timeFormat  = response['time'].split(':');
            var timer       = startTime(timeFormat);
        });
    });

    $(function()
    {
        $('#test-date').click(function() {
            if (!$('#set-date').val()) {
                swal('Select a date to test');
            } else {
                $('.btn').attr('disabled', true);
                enableButtons();
                let seconds = $('#set-date').val().slice(17);
                seconds += '000';
                $.ajax({
                    url: '{{ route("cron.set-date") }}',
                    method: 'GET',
                    data: {
                        date: $('#set-date').val()
                    },
                });
                setTimeout(()=>{
                    $.ajax({
                        url: '{{ route("cron.get-date") }}',
                        method: 'GET',
                    }).done(function(response) {
                        $('#display').html('Date changed '+response['date'] + ' ' +response['time'] + '<br>');
                        $('#date').html('Today: '+response['date']);
                        var timeFormat = response['time'].split(':');
                        var timer = startTime(timeFormat);
                    });
                },2000);
                setTimeout(()=>{
                    $.ajax({
                        url: '{{ route("cron.get-date") }}',
                        method: 'GET',
                    }).done(function (response) {
                        $('#date').html('Today: ' + response['date']);
                    });                    
                },62000 - seconds);
            }
        });
    });

    $(function() 
    {
        $('#reset-date').click(function() {
            $('.btn').attr('disabled', true);
            enableButtons();
            $.ajax({
                url: '{{ route("cron.reset-date") }}',
                method: 'GET',
                beforeSend: showLoader(),
                complete: hideLoader()
            });
            setTimeout(()=>{
                $.ajax({
                    url: '{{ route("cron.get-date") }}',
                    method: 'GET',
                    beforeSend: showLoader(),
                    complete: hideLoader()
                }).done(function(response) {
                    $('#display').html('Date reset '+response['date'] + ' ' +response['time'] + '<br>');
                    $('#date').html('Today: '+response['date']);
                    var timeFormat = response['time'].split(':');
                    var timer = startTime(timeFormat);
    
                });
            },2000);
        });
    });

    $(function() 
    {
        $('#restart-apache').click(function() {
            $('.btn').attr('disabled', true);
            enableButtons();
            $.ajax({
                url: '{{ route("cron.restart-server") }}',
                method: 'GET'
            }).done(function(response) {
                $('#display').html(response + '<br>');

            });
        })
    });

    $(function()
    {
        $('#restart-php').click(function() {
            $('.btn').attr('disabled', true);
            enableButtons();
            $.ajax({
                url: '{{ route("cron.restart-php") }}',
                method: 'GET'
            }).done(function(response) {
                $('#display').html(response + '<br>');

            });
        });
    });

    $(function()
    {
        $('#clean-cache').click(function() {
            $('.btn').attr('disabled', true);
            enableButtons();
            $.ajax({
                url: '{{ route("cron.clean-cache") }}',
                method: 'GET'
            }).done(function(response) {
                $('#display').html('Cache Cleaned' + '<br>');

            });
        });
    });

    function startTime(timeFormat)
    {

        $('#test-date').click(function(){
            clearInterval(timer);
        });

        $('#reset-date').click(function(){
            clearInterval(timer);
        });

        var hours      = timeFormat[0];
        var minutes    = timeFormat[1];
        var seconds    = timeFormat[2];

        var timer = setInterval(()=>{

            if (seconds < 59) {
                seconds++;
                seconds = seconds < 10 ? '0' + seconds : seconds;
            } else {
                seconds = '0' + 0;
                minutes++;
                minutes = minutes < 10 ? '0' + minutes : minutes;
            }
            if (minutes > 59) {
                minutes = '0' + 0;  
                if (hours < 23) {
                    hours++;
                    hours = hours < 10 ? '0' + hours : hours;
                } else {
                    hours = 0;
                    hours = '0' + 0;
                }
            }
            if (hours <= 9 && hours.length < 2) {
                hours = '0' + hours;
            }

            $('#time').html(', Time (In 24 HRS format): '+hours+':'+minutes+':'+seconds);

        },1000);
        
    }

    function enableButtons()
    {
        var count = 5;

        setTimeout(()=>{

            $('.btn').attr('disabled', false);

        },3000);

    }

    $(function deleteUserdata()
    {
        $('#delete-userdata').click(function () {
            $.ajax({
                url: '{{ route("cron.prepare-delete") }}',
                method: 'GET'
            }).done((response)=>{
                swal({
                    title: 'Delete Userdata?',
                    text: 'Database: '+response['database_name']+
                          '\nTotal Customers: '+response['total_users']+
                          '\nCompany Id: '+response['company_id'],
                    icon: 'warning',
                    buttons: ['No', 'Yes']
                }).then((response)=>{
                    if (response) {
                        $.ajax({
                        url: '{{ route("cron.clear-userdata") }}',
                        method: 'GET',
                        }).done(function(response) {
                            if (response) {
                                if (response['error']) {
                                    swal ({
                                        title: response['error']['message'],
                                        text: 'Error Code: '+response['error']['code'],
                                        icon: 'error'
                                    });
                                } else {
                                    swal ({
                                        title: 'Data Deleted',
                                        icon: 'success'
                                    });
                                }
                            }
                        });
                    }
                });
            });
        })
    });
    
</script>
@endpush

<style>
    .button-color {
        background: #8b00da;
        color: white;
        border: solid 1px transparent;
        padding: 5px;
        transition: 0.5s;
        border-radius: 3px;
    }
    .button-color:hover {
        background: white;
        color: #8b00da;
        border-color: #8b00da;
        transition: 0.5s;
    }
</style>