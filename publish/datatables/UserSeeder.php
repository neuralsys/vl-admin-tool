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
        \App\Models\User::firstOrCreate([
            'email' => 'admin@gmail.com',
            'password' => '123456',
            'name' => 'Admin',
            'email_verified_at' => \Carbon\Carbon::now()
        ]);
    }
}
