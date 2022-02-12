<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Hijrian;

class TestController extends Controller
{

    public function home()
    {
        return redirect()->route('home');
    }
}
