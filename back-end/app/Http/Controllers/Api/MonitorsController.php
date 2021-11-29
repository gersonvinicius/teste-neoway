<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Monitor;
use Illuminate\Http\Request;

class MonitorsController extends Controller
{
    public function index()
    {
        return Monitor::all();
    }
}
