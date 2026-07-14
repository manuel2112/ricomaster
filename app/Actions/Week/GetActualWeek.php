<?php

namespace App\Actions\Week;

use App\Models\Week;
use Lorisleiva\Actions\Concerns\AsAction;

class GetActualWeek
{
    use AsAction;

    public function handle(): Week
    {
        return Week::where('actual', true)
            ->firstOrFail();
    }
}
