<?php

namespace Database\Seeders;

use App\Models\AvailableJob;
use Illuminate\Database\Seeder;

class AvailableJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AvailableJob::factory(5)->create();
    }
}
