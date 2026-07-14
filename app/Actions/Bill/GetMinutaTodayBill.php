<?php

namespace App\Actions\Bill;

use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMinutaTodayBill
{
    use AsAction;

    public function handle(): Collection
    {
        // $today = Carbon::now()->addDays(2)->format('Y-m-d');
        $today = Carbon::now()->format('Y-m-d');

        return Bill::where('day', $today)
            ->with(['menu', 'typeMenu'])
            ->get();
    }
}
