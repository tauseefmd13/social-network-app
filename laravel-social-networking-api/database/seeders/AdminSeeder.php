<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
           'name' => 'superadmin',
           'email' => 'superadmin@gmail.com',
           'password' => bcrypt('12345678'),
           'role' => 'super_admin',
        ]);
    }
}
