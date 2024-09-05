<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function dashboardTest(){
        return view('test.dashboard');
    }
}
