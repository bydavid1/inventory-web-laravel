<?php

namespace Database\Seeders;

use App\Invoice_type;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Invoice_type();
        $role->type = 'Consumidor final';
        $role->save();

        $role = new Invoice_type();
        $role->type = 'Credito fiscal';
        $role->save();
    }
}
