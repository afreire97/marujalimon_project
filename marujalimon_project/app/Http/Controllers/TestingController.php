<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestingController extends Controller
{
    public function index(){
        Log::info("Testing");
        return view('testing.calendar');
    }
}
