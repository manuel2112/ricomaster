<?php

namespace App\Actions\Week;

use App\Data\Week\ScheduleWeekExistData;
use App\Models\Week;
use Lorisleiva\Actions\Concerns\AsAction;

class ScheduleWeekExist
{
    use AsAction;

    public function handle(ScheduleWeekExistData $dto): ?Week
    {
        $week = Week::where('week', $dto->week)
            ->where('year', $dto->year)
            ->where('actual', true)
            ->first();

        if ($week) {
            return null;
        } else {
            return Week::where('week', $dto->week)
                ->where('year', $dto->year)
                ->first();
        }
    }
}
