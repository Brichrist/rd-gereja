<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Util;

class PageController extends Controller
{
    public function index(){
        return view('index');
    }
}
