<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index() {
        $breadcrumbs = [
            ["link" => "/home", "name" => "Home"],
            ["name" => "Configuración"]
        ];

        return view('pages.configuration', ['breadcrumbs'=>$breadcrumbs]);
    }
}
