<?php

namespace Database\Seeders;

use App\Models\MeasurementUnit;
use Illuminate\Database\Seeder;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unit = new MeasurementUnit();
        $unit->name = "Unidad";
        $unit->prefix = "u";
        $unit->save();
    }
}
