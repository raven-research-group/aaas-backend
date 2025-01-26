<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $organization = Organization::create([
            'id'               => (string) Str::uuid(),
            'name'             => 'Cran stack',
            'primary_contact'  => '233540702934',
            'secondary_contact' => 'james.obeng@gmail.com',
        ]);
        Admin::create([
            'id'             => (string) Str::uuid(),
            'name'           => 'James kofi ottopah',
            'email'          => 'ottopahkofijames@gmail.com',
            'password'       => Hash::make('Onetwothree@8.'),
            'organization_id'=> $organization->id,
        ]);
    }
}
