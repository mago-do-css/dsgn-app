<?php

namespace Database\Seeders;

use App\Models\User; 
use App\Models\UserLimits; 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('teste@123'),
        ]);

        UserLimits::create([ 
            'user_id' => 1,
            'limit' => 5,
        ]); 

        $this->call(
            S01_DownloadHistorySeeder::class,
            //adicionar próximo
        );
    }
}