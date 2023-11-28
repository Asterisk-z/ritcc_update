<?php

namespace App\Http\Controllers\FMDQ;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    //
    public function index()
    {
        return view('fmdq.settings.index');
    }
}
