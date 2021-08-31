<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = new Company();
        $config->name = "E-box system";
        $config->description = "";
        $config->address = "";
        $config->contact_email =  "";
        $config->phone = "";
        $config->logo = "assets/media/ebox.png";
        $config->save();
    }
}
