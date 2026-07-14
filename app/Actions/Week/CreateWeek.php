<?php

namespace App\Actions\Week;

use App\Models\Week;
use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateWeek
{
    use AsAction;

    public function handle(): void
    {
        $fechaActual = Carbon::now();
        $year = Carbon::now()->year;

        for ($i = 1; $i <= 10; $i++) {
            $numeroSemana = $fechaActual->isoWeek() + $i;
            $weekCarbon = Carbon::now()->setISODate($year, $numeroSemana)->startOfWeek();
            $firstDay = $weekCarbon->format('Y-m-d');

            $date = Carbon::parse($firstDay);
            $thisYear = $date->year;
            $weekOfYear = $date->weekOfYear;

            $exist = Week::where('week', $weekOfYear)->where('year', $thisYear)->where('first_day', $firstDay)->exists();

            if (! $exist) {
                $week = new Week();
                $week->week = $weekOfYear;
                $week->year = $thisYear;
                $week->first_day = $firstDay;
                $week->save();
            }
        }
    }
}
