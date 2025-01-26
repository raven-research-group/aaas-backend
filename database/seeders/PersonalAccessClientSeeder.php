<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;

class PersonalAccessClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Check if a personal access client already exists
        if (DB::table('oauth_personal_access_clients')->exists()) {
            $this->command->info('Personal Access Client already exists.');
            return;
        }

        $clientRepository = app(ClientRepository::class);

        // Create the personal access client
        $client = $clientRepository->createPersonalAccessClient(
            $userId = null, // Not tied to a specific user
            $name = 'Personal Access Client', // Name of the client
            $redirect = '' // Redirect URI is not needed
        );

        $this->command->info('Personal Access Client created successfully.');
    }
}
