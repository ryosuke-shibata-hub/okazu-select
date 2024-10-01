<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function welcomePage()
    {
        return view('page.welcomePage');
    }

    public function topPage()
    {
        return view('page.topPage');
    }
}
