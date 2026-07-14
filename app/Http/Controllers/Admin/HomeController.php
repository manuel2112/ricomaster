<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function get(Request $request): View
    {
        return view('admin.home');
    }

    public function orderDetail(Request $request): View
    {
        return view('admin.order-detail');
    }
}
