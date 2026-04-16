<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class KycController extends Controller
{
    function index() : View
    {
        return view('frontend.page.kyc');
    }
}