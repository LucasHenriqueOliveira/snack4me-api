<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // default user
        $profile = DB::table('profiles')->where('name','administrator')->first();
        if (!$profile) {
            $profile_id = DB::table('profiles')->insertGetId([
                'name' => 'administrator'
            ]);
            $profile = DB::table('profiles')->find($profile_id);
        }


        $user = DB::table('users')->find(1);
        if (!$user) {
            $user_id = DB::table('users')->insertGetId([
                'name' => 'Snack Admin',
                'username' => 'snack',
                'password' => Hash::make('teste'),
                'cpf' => '00011122233',
                'profile_id' => $profile->id
            ]);
            $user = DB::table('users')->find($user_id);
        }
    }
}
