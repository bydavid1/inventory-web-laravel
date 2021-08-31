<?php

namespace Database\Seeders;

use App\Models\MeasurementUnit;
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
        $this->call(RoleTableSeeder::class);
        $this->call(TaxSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(UnitsSeeder::class);
        $this->call(POSSeeder::class);
        $this->call(ConfigurationSeeder::class);
    }
}
