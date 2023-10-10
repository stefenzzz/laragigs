<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
       $users = User::factory(6)->create();
        
        foreach($users as $user)
        {
            Listing::factory()->create([
                'user_id' => $user->id
            ]);
        }

  

  

        
    }
}
