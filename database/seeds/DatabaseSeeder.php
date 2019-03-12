<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {

    public function run() {
        Model::unguard();
        $this->call(InitialDataSeeder::class);
        Model::reguard();
    }
}