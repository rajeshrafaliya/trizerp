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
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Edit User') }}</div>

                <div class="card-body">
                @if ($sessionData = Session::get('data'))
                <div class="@if($sessionData['status_code']==1) alert alert-success alert-block @else alert alert-danger alert-block @endif ">              
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $sessionData['message'] }}</strong>
                </div>
                @endif               
                        
                <form action="{{ route('user.update',$data['user_data']['id']) }}" method="post">                          
                    {{ method_field("PUT") }}
                    @csrf                  

                  <div class="form-group">
                    <label for="exampleInputEmail1">User Name</label>
                    <input type="text" class="form-control" name="user_name" id="user_name" value="{{$data['user_data']['name']}}" required>                        
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Subscription Plan</label>
                    <select id="subscription_plan_id" name="subscription_plan_id" class="form-control" required>
                        <option value="">Select Plan</option>                       
                        @foreach($data['subscription_data'] as $key => $val)
                            @php
                            $selected = "";
                            if($data['user_data']['subscription_plan_id'] == $val['id'])
                            {
                                $selected = "selected";
                            }
                            @endphp
                            <option {{$selected}} value="{{$val['id']}}">{{$val['title']}}</option>                       
                        @endforeach
                    </select>
                  </div>
                                                  
                  <button type="submit" class="btn btn-primary">Update</button>
                </form>                    
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

