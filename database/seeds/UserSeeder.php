<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //if(DB::table('users')->count() == 0){

            DB::table('users')->insert([

                [
                    'name' => 'sonika',
                    'email' => 'sonika@triz.co.in',
                    'password' => Hash::make('password'),
                    'subscription_plan_id' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'rohit',
                    'email' => 'rohit@triz.co.in',
                    'password' => Hash::make('password'),
                    'subscription_plan_id' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],  
                [
                    'name' => 'karan',
                    'email' => 'karan@triz.co.in',
                    'password' => Hash::make('password'),
                    'subscription_plan_id' => '1',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]

            ]);
        //}    
    }
}
