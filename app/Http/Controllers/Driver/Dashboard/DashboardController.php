<?php

namespace App\Http\Controllers\Driver\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.driver.dashboard.index');
    }
}
