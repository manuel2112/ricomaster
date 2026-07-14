<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function get(Request $request): View
    {
        return view('public.menu');
    }

    public function associated(Request $request): View
    {
        return view('public.associated');
    }
}
