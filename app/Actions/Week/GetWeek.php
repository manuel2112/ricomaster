<?php

namespace App\Actions\Week;

use App\Data\Week\GetWeekData;
use App\Models\Week;
use Lorisleiva\Actions\Concerns\AsAction;

class GetWeek
{
    use AsAction;

    public function handle(GetWeekData $dto): Week
    {
        return Week::where('week', $dto->week)
            ->where('year', $dto->year)
            ->firstOrFail();
    }
}
