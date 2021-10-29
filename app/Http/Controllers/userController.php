<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\meeting;
use App\Models\meetingRoomMaster;
use App\Models\subscription_plan_master;
use App\User;
use DB;

class userController extends Controller
{    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {                
        $data = $this->getData($request);                                                               
        return view('edit_user', ["data"=>$data]);
    } 

    public function getData($request)
    {
        $user_id = session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');

        $user_data = User::select('*')
                            ->where(['id'=>$user_id])                            
                            ->get()->toArray();  
        $data['user_data'] = $user_data[0];

        $data['subscription_data'] = subscription_plan_master::select('*')                                                
                            ->get()->toArray();                            
        return $data;
    }

    public function update(Request $request,$id)
    {       
        $data = array(
            "name" => $request->input('user_name'),
            "subscription_plan_id" => $request->input('subscription_plan_id')
        );
        User::where(["id" => $id])->update($data);

        return view('home');
    }
}
