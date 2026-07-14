<?php

namespace App\Actions\Week;

use App\Data\Week\UpdateWeekData;
use App\Models\Week;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateWeek
{
    use AsAction;

    public function handle(UpdateWeekData $dto): void
    {
        $week = Week::find($dto->id);

        if ($week) {

            $data = $dto->toArray();
            foreach ($data as $key => $value) {
                if ($value !== null) {
                    $week->$key = $value;
                }
            }

            $week->save();
        }
    }
}
