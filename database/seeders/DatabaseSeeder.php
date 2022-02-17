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
        \App\Models\User::factory(1)->create();
        \App\Models\Customer::factory(3)->create();
        \App\Models\Supplier::factory(1)->create();
        \App\Models\Project::factory(5)->create();
    }
}
