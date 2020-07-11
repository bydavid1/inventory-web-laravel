<?php

use Illuminate\Database\Seeder;
use App\Tax_rules;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seed = new Tax_rules();
        $seed->percentage = "13";
    }
}