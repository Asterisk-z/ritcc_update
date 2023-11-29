<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Institution::factory(10)->create();
        \App\Models\Profile::factory(5)->create();
        // \App\Models\Security::factory(5)->create();
    }
}