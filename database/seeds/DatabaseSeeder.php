<?php

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
        $this->call(InvoiceSeeder::class);
        $this->call(KardexSeeder::class);
    }
}
