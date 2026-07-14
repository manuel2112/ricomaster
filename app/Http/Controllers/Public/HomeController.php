<?php

namespace App\Http\Controllers\Public;

use App\Actions\Bill\GetMinutaDayBill;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly GetMinutaDayBill $getMinutaDayBill,
    ) {}

    public function get(): View
    {
        $minuta = $this->getMinutaDayBill->handle();
        $array = [];

        foreach ($minuta as $key => $item) {
            foreach ($item['menus'] as $menu) {
                $array[] = $menu;
            }
        }

        $random = Arr::random($array, 9);

        return view('public.home', compact('random'));
    }
}
