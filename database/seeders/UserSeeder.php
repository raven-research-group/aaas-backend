<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'James Obeng',
            'email' => 'obengkofijames@gmail.com',
            'password' => Hash::make('amenamen'),
            'type' => 'user', 
            'primary_contact' => '233540702934', 
            'secondary_contact' => '0987654321',
        ]);
    }
}
