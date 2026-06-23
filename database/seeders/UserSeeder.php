<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $admin = ['name' => 'admin-test' ,'email' => 'admin@test.com' ,  'password' =>123 , 'email_verified_at' => now(), 'type' => 'admin'];
        $custmer = ['name' => 'custmer-test' ,'email' => 'customer@test.com' ,  'password' =>123 , 'email_verified_at' => now(),];
        User::create($admin);
        User::create($custmer);
    }
}
