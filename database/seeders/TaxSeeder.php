<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tax_rules;

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
        $seed->save();
    }
}
