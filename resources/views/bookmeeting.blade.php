@extends('layouts.app')

@section('scripts')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
  //$.noConflict();

  
    $('.mydatepicker').datetimepicker({
        format:'YYYY-MM-DD HH:mm:ss'
    });
  
});

function get_meetingroom(total_member)
{
    var path = "{{ route('ajax_getMeetingRoom') }}";
    var datetime = $("#meeting_datetime").val();//'2021-10-27 03:45:31';
    var meeting_duration = $("#meeting_duration").val();//'2021-10-27 03:45:31';

    if(datetime != "" && meeting_duration != "")
    {        
        $('#meeting_roomid').find('option').remove().end().append('<option value="">Select Room</option>').val('');
        $.ajax({
            url: path,
            data:'total_member='+total_member+'&datetime='+datetime, 
            success: function(result)
            {             
                for(var i=0;i < result.length;i++)
                {           
                    var display_title = result[i]['title'] + ' ( with ' + result[i]['capacity'] + ' capacity' + ' )';     
                    $("#meeting_roomid").append($("<option></option>").val(result[i]['id']).html(display_title));  
                } 
                if(result.length == 0)
                {
                    alert("Meeting Room not available with capacity of "+ total_member + ' person at ' + datetime + ' time')
                }
            }
        });
    }
    else
    {
            alert("Please Select Meeting Datetime and Duration");
    }
}
</script>
@endsection

<style>
.mydatepicker {
    display: inherit;
}
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Book Meeting') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('bookmeeting.store') }}" method="post">                          
                        {{ method_field("POST") }}
                        @csrf 
                      <div class="form-group">
                        <label for="exampleInputEmail1">Meeting Name</label>
                        <input type="text" class="form-control" name="meeting_name" id="meeting_name" placeholder="Enter Meeting Name" required>                        
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Meeting Duration</label>
                        <select id="meeting_duration" name="meeting_duration" class="form-control" required>
                            <option value="">Select Duration</option>
                            <option value="30">30 Mins</option>
                            <option value="60">60 Mins</option>
                            <option value="90">90 Mins</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Meeting Date-time</label>                        
                        <div class='input-group mydatepicker'>
                           <input type='text' class="form-control" name="meeting_datetime" id="meeting_datetime" autocomplete="off" />
                           <span class="input-group-addon">
                           <span class="glyphicon glyphicon-calendar"></span>
                           </span>
                        </div>                            
                      </div>                     
                      <div class="form-group">                        
                        <label for="exampleInputPassword1">Total Members</label>
                        <input type="number" max="{{$data['max_capacity']}}" id="total_member" name="total_member" class="form-control" required onblur="get_meetingroom(this.value);" />                            
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Meeting Room</label>
                        <select id="meeting_roomid" name="meeting_roomid" class="form-control" required>
                            <option value="">Select Room</option>
                        </select>
                      </div>                      
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

