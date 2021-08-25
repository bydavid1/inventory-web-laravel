<?php

namespace Database\Seeders;

use App\Models\POS;
use Illuminate\Database\Seeder;

class POSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pos = new POS();
        $pos->branch_id = 1; //Temporally
        $pos->name = 'Caja 1';
        $pos->value = '0.00';
        $pos->save();
    }
}
