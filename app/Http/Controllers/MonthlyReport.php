<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonthlyReport extends Controller
{
    public function index() {
        return view('monthly_report');
    }
}
