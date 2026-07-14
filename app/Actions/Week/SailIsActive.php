<?php

namespace App\Actions\Week;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class SailIsActive
{
    use AsAction;

    public function handle(): bool
    {
        $now = Carbon::now();

        $start = Carbon::parse('10:15');
        $end = Carbon::parse('15:00');
        $now = Carbon::now();

        $arrayDays = [1, 2, 3, 4, 5];

        if (in_array($now->dayOfWeekIso, $arrayDays)) {

            if ($now->between($start, $end)) {
                return false;
            }
        }

        return true;
    }
}
