@extends('layouts.app')

@section('scripts')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>


<script>

    $(document).ready(function() {
        $('.mydatepicker').datetimepicker({
            format:'YYYY-MM-DD HH:mm:ss'
        });

     var table = $('#example').DataTable( {
         select: true,          
         lengthMenu: [ 
                        [100, 500, 1000, -1], 
                        ['100', '500', '1000', 'Show All'] 
        ],
        dom: 'Bfrtip', 
        buttons: [ 
            { 
                extend: 'pdfHtml5',
                title: 'Fees Monthly Report',
                orientation: 'landscape',
                pageSize: 'LEGAL',                
                pageSize: 'A0',
                exportOptions: {                   
                     columns: ':visible'                             
                },
            }, 
            { extend: 'csv', text: ' CSV', title: 'Fees Monthly Report' }, 
            { extend: 'excel', text: ' EXCEL', title: 'Fees Monthly Report'}, 
            { extend: 'print', text: ' PRINT', title: 'Fees Monthly Report'}, 
            'pageLength' 
        ], 
        }); 

        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" size="3" placeholder="Search '+title+'" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    } );

    function check_availablity(x)
    {
        if(x <= 0)
        {
            alert("You have reached your maximum booking limits for the day");
            return false;
        }
        else
        {
            return true;
        }
    }
</script>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Show Book Meeting') }}</div>

                <div class="card-body">
                @if ($sessionData = Session::get('data'))
                <div class="@if($sessionData['status_code']==1) alert alert-success alert-block @else alert alert-danger alert-block @endif ">              
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $sessionData['message'] }}</strong>
                </div>
                @endif                              
                        
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('bookmeeting.create') }}" class="btn btn-info add-new" onclick="return check_availablity({{$allowed_booking}});"><i class="fa fa-plus"></i> Book Meeting</a>
                    </div> 

                    <div class="col-md-12 mt-4">
                        <form action="{{ route('search_user') }}">                        
                            @csrf
                            <div class="row">                    
                                <div class="col-md-4 form-group">
                                    <label>From Date</label>
                                    <input type="text" name="from_date" class="form-control mydatepicker" value="@if(isset($from_date)) {{$from_date}} @endif" placeholder="Please select from date." autocomplete="off">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>To Date</label>
                                    <input type="text" name="to_date" class="form-control mydatepicker" value="@if(isset($to_date)) {{$to_date}} @endif" placeholder="Please select to date." autocomplete="off">
                                </div>
                                <div class="col-md-4 form-group mt-4">                                    
                                    <input type="submit" name="submit" value="Search" class="btn btn-success" >                                
                                </div>
                            </div>                     
                        </form>
                    </div> 


                    <div class="col-lg-12 col-sm-12 col-xs-12" style="overflow:auto;">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Meeting Name</th>
                                        <th>Meeting Duration</th>                                       
                                        <th>Meeting Date-time</th>
                                        <th>Meeting Room Name</th>
                                        <th>Total Members</th>                                                            
                                        <th>Action</th>                                                            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data) > 0)
                                    @php $i = 1;@endphp
                                    @foreach($data as $key => $val)
                                    <tr>    
                                        <td>@php echo $i++;@endphp</td>                                
                                        <td>{{$val['meeting_name']}}</td>                                 
                                        <td>{{$val['meeting_duration']}} min</td>                                 
                                        <td>{{$val['meeting_datetime']}}</td>                                 
                                        <td>{{$val['title']}}</td>                                 
                                        <td>{{$val['total_member']}}</td> 
                                        <td>                                
                                            <form action="{{ route('bookmeeting.destroy', $val['id'])}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirmDelete();" type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>                             
                                            </form>  
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        <tr><td colspan="20"><center>No records</center></td></tr>
                                    @endif                           
                                </tbody>
                            </table>
                        </div>
                    </div>                
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

