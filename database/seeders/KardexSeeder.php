<?php

namespace Database\Seeders;

use App\Models\Kardex_type;
use Illuminate\Database\Seeder;

class KardexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kardex = new Kardex_type();
        $kardex->tag = "Ingreso al inventario";
        $kardex->save();

        $kardex = new Kardex_type();
        $kardex->tag = "Venta en factura";
        $kardex->save();

        $kardex = new Kardex_type();
        $kardex->tag = "Compra en factura";
        $kardex->save();
    }
}
