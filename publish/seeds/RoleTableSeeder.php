<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::firstOrCreate([
            'code' => \App\Models\Role::SUPER_ADMIN,
            'title' => 'Super Admin'
        ]);
    }
}
