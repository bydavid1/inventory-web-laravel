<?php

namespace Database\Seeders;

<<<<<<< HEAD
=======
use App\Models\MeasurementUnit;
>>>>>>> database
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
<<<<<<< HEAD
        $this->call(InvoiceSeeder::class);
        $this->call(KardexSeeder::class);
=======
        $this->call(BranchSeeder::class);
        $this->call(UnitsSeeder::class);
        $this->call(POSSeeder::class);
        // $this->call(InvoiceSeeder::class);
        // $this->call(KardexSeeder::class);
>>>>>>> database
    }
}
