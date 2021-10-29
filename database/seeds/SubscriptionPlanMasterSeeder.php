<?php

use Illuminate\Database\Seeder;

class SubscriptionPlanMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //if(DB::table('users')->count() == 0){

            DB::table('subscription_plan_master')->insert([
                [                    
                    'title' => 'Free Plan',
                    'allowed_booking' => '3',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [                    
                    'title' => 'Basic Plan',
                    'allowed_booking' => '5',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'title' => 'Advance Plan',
                    'allowed_booking' => '7',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'title' => 'Premium Plan',
                    'allowed_booking' => '10',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]

            ]);
        //}    
    }
}
