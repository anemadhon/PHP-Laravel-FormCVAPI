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
        $this->call([
            AvailableJobSeeder::class,
            SkillSeeder::class,
            CountrySeeder::class,
            CitySeeder::class
        ]);
    }
}
