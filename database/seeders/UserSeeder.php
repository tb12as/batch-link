<?php

namespace Database\Seeders;

use App\Models\User;
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
        $syafiq = [
        	'name' => 'Syafiq',
        	'email' => 'admin@gmail.com',
        	'password' => bcrypt('1234'),
        ];

        User::create($syafiq);

    }
}
