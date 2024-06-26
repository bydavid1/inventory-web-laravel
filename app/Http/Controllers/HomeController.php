<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            ["link" => "/", "name" => "Home"],
            ["name" => "Dashboard"]
        ];
        $pageConfigs = ["mainLayoutType" => "vertical-menu"];


        $request->user()->authorizeRoles(['user', 'admin']);
        return view('pages.home', compact(['breadcrumbs', 'pageConfigs']));
    }
}
