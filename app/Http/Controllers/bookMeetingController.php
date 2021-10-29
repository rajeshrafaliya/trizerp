<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\meeting;
use App\Models\meetingRoomMaster;
use App\Models\subscription_plan_master;
use App\User;
use DB;

class bookMeetingController extends Controller
{    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {        
        $data = $this->getData($request);

        $user_id = session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');

        $booking_data = meeting::select(DB::raw('(allowed_booking - count(*)) as available_meeting'))
                            ->join('users as u','u.id','meeting.created_by')
                            ->join('subscription_plan_master as s','s.id','u.subscription_plan_id')
                            ->where(['meeting.created_by'=>$user_id])
                            ->whereraw("date_format(meeting.created_at,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d')")                           
                            ->get()->toArray();        
        $allowed_booking = $booking_data[0]['available_meeting'];                                        
             
        return view('show_bookmeeting', ["data"=>$data,"allowed_booking"=>$allowed_booking]);
    }

    public function getData($request)
    {
        $user_id = session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        $meeting_data = meeting::select(DB::raw('meeting.*,rm.title'))
                ->join('meetingroom_master as rm','rm.id','meeting.meeting_roomid')
                ->where('created_by','=',$user_id)
                ->whereraw('meeting_datetime > now()')
                ->orderby('meeting_datetime','desc')
                ->get()->toArray();

        return $meeting_data;
    }

    public function search_user(Request $request)    
    {
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $user_id = session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');

        $booking_data = meeting::select(DB::raw('(allowed_booking - count(*)) as available_meeting'))
                            ->join('users as u','u.id','meeting.created_by')
                            ->join('subscription_plan_master as s','s.id','u.subscription_plan_id')
                            ->where(['meeting.created_by'=>$user_id])
                            ->whereraw("date_format(meeting.created_at,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d')")                           
                            ->get()->toArray();        
        $allowed_booking = $booking_data[0]['available_meeting'];  

        $user_id = session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        $meeting_data = meeting::select(DB::raw('meeting.*,rm.title'))
                ->join('meetingroom_master as rm','rm.id','meeting.meeting_roomid')
                ->where('created_by','=',$user_id)
                ->whereraw('meeting_datetime between "'.$from_date.'" and "'.$to_date.'"')
                ->orderby('meeting_datetime','desc')
                ->get()->toArray();

        return view('show_bookmeeting', ["data"=>$meeting_data,"allowed_booking"=>$allowed_booking,"from_date"=>$from_date,"to_date"=>$to_date]);
        
    }

    public function create(Request $request)
    {        
        $data = meetingRoomMaster::select(DB::raw('max(capacity) as max_capacity'))                
               ->get()->toArray();
       return view('bookmeeting',["data"=>$data[0]]); 
    }

    public function store(Request $request)
    {          
        $user_id = session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        $meeting_arr = array(
            'meeting_name' => $request->get('meeting_name'),
            'meeting_duration' => $request->get('meeting_duration'),
            'meeting_datetime' => $request->get('meeting_datetime'),
            'total_member' => $request->get('total_member'),
            'meeting_roomid' => $request->get('meeting_roomid'),           
            'created_by' => $user_id,          
            'created_at' => date('Y-m-d h:i:s'),          
            'updated_at' => date('Y-m-d h:i:s')          
        );                 
        
        meeting::insert($meeting_arr);

        return redirect()->route('bookmeeting.index');

    }

    public function destroy(Request $request,$id){
                
        meeting::where(["id" => $id])->delete();
        return redirect()->route('bookmeeting.index');
    }

    public function ajax_getMeetingRoom(Request $request)
    {
        $total_member = $request->input("total_member");
        $datetime = $request->input("datetime");
        
        $sql = "SELECT * FROM (
                    SELECT meeting_roomid,DATE_ADD(meeting_datetime, INTERVAL meeting_duration MINUTE) AS available_time
                    FROM `meeting`
                    WHERE meeting_roomid IN (SELECT id FROM meetingroom_master WHERE capacity >= '".$total_member."') 
                    AND '".$datetime."' BETWEEN meeting_datetime AND DATE_ADD(meeting_datetime, INTERVAL meeting_duration MINUTE)
                ) a
                RIGHT JOIN 
                (
                    SELECT * FROM meetingroom_master WHERE capacity >= '".$total_member."' 
                ) 
                b on a.meeting_roomid  = b.id
                WHERE a.meeting_roomid IS NULL";

        $room_data = DB::select($sql);
        $room_data = json_decode(json_encode($room_data),true);

        return $room_data;
       
    }

}
