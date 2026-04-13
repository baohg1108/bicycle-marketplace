<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class UserDashboardController extends Controller
{
    function index() : View 
    {
        return view('frontend.dashboard.main.index');
    }
}