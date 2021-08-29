<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
<<<<<<< HEAD
use App\Models\Tax_rules;
=======
use App\Models\Tax;
>>>>>>> database

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        $seed = new Tax_rules();
=======
        $seed = new Tax();
>>>>>>> database
        $seed->percentage = "13";
        $seed->save();
    }
}
