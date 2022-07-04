<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function rDashboard()
    {
    	return view('users.dashboard');
    }
    public function rCategory()
    {
    	return view('users.category_list');
    }

    public function rProduct()
    {
    	return view('users.product_list');
    }
}
