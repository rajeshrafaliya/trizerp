<?php

use Illuminate\Database\Seeder;

class MeetingRoomMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //if(DB::table('users')->count() == 0){

            DB::table('meetingroom_master')->insert([
                [                    
                    'title' => 'Meeting Room 1',
                    'capacity' => '3',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [                    
                    'title' => 'Meeting Room 2',
                    'capacity' => '10',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'title' => 'Meeting Room 3',
                    'capacity' => '15',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'title' => 'Meeting Room 4',
                    'capacity' => '2',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'title' => 'Meeting Room 5',
                    'capacity' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]);
        //}    
    }
}
