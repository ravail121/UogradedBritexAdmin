@extends('layouts._app-auth')



@section('page-title')
    TBC Report
@endsection

@section('content')
 <h3> Lines Active on TMO and Not in Active in DB</h3>

 <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Phone Number</th>
                        <th scope="col">BAN</th>
                        <th scope="col">TMO Status</th>
                        <th scope="col">DB Status</th>
                        <th scope="col">Date Identified</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $key => $bd)
                        <tr class= "display">
                            <td>{{$bd->phone_number}}</td>
                            <td>{{$bd->ban_number}}</td>
                            <td>{{$bd->tbc_status}}</td>
                            <td>{{$bd->db_status}}</td>
                            <td>{{$bd->date_identified}}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <nav aria-label="Page navigation example" class="mypagination">
                        {!! $details->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                    </nav>
                </div>
            </div>

  </div>

   <h3> Lines Active in DB and not active on TMO</h3>

 <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Phone Number</th>
                        <th scope="col">BAN</th>
                        <th scope="col">TMO Status</th>
                        <th scope="col">DB Status</th>
                        <th scope="col">Date Identified</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($details2 as $key => $bd)
                        <tr class= "display">
                            <td>{{$bd->phone_number}}</td>
                            <td>{{$bd->ban_number}}</td>
                            <td>{{$bd->tbc_status}}</td>
                            <td>{{$bd->db_status}}</td>
                            <td>{{$bd->date_identified}}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <nav aria-label="Page navigation example" class="mypagination">
                        {!! $details2->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                    </nav>
                </div>
            </div>

  </div>


@endsection

@push('js')
<script>
</script>
@endpush
      