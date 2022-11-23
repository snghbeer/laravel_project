<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@ehb.be',
                'password' => Hash::make('Password!321'),
                'avatar' => null,
                'role' => 1
            ], [
                'name' => 'snghbeer',
                'email' => 'nivonsay.jean@hotmail.com',
                'password' => Hash::make('Lolpapa1'),
                'avatar' => 'avatars/3.png',
                'role' => 0
            ]
        ]);
    }
}
