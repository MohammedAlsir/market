<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user  = new User();
        $user->role = 1;
        $user->name = 'admin';
        $user->email = 'admin@site.com';
        $user->password = Hash::make('123456789');
        $user->save();
    }
}