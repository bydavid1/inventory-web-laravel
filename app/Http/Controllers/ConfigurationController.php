<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ConfigurationController extends Controller
{
    public function index() {

        $siteInfo = Company::first();
        $breadcrumbs = [
            ["link" => "/home", "name" => "Home"],
            ["name" => "Configuración"]
        ];

        if ($siteInfo) {
            return view('pages.configuration', ['breadcrumbs'=> $breadcrumbs, 'siteinfo' => $siteInfo]);
        } else {

        }


    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'name' => 'required|max:50'
            ]);

            if ($validated) {
                $config = Company::first();
                if ($config) {
                    $config->name = $request->name;
                    $config->description = $request->description;
                    $config->address = $request->address;
                    $config->contact_email =  $request->email;
                    $config->phone = $request->contact;
                    $config->save();
                } else {
                    $company = new Company();
                    $company->name = $request->name;
                    $company->description = $request->description;
                    $company->address = $request->address;
                    $company->contact_email =  $request->email;
                    $company->phone = $request->contact;
                    $company->save();
                }
            }

            return back()->with('message', 'Configuracion guardada');
        } catch (\Exception $e) {
            return back()->with('error-message', $e->getMessage());
        }
    }
}
