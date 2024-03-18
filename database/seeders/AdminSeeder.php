<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $password = Hash::make('123456');
        DB::table('users')->insert([
            [
                "name" => 'Super Admin',
                "email" => 'dashboard@dash.com',
                "admin" => "1",
                "account" => "9",
                "suspend" => "0",
                "active" => "1",
                "password" => $password
            ], 
        ]);
    }
}
