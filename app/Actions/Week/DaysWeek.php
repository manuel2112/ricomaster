<?php

namespace App\Actions\Week;

use App\Data\Week\DaysWeekData;
use App\Data\Week\GetWeekData;
use App\Models\Week;
use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class DaysWeek
{
    use AsAction;

    public function __construct(
        private readonly GetWeek $getWeek,
    ) {
    }

    public function handle(DaysWeekData $dto): array
    {
        if ($dto->week) {
            $week = Week::where('week', $dto->week)->firstOrFail();
            $numeroSemana = $dto->week;
            $dateString = $week->first_day.'00:00:00';
            $format = 'Y-m-d H:i:s';
            $weekCarbon = Carbon::createFromFormat($format, $dateString);
        } elseif ($dto->id) {
            $week = Week::where('id', $dto->id)->firstOrFail();
            $numeroSemana = $week->week;
            $dateString = $week->first_day.'00:00:00';
            $format = 'Y-m-d H:i:s';
            $weekCarbon = Carbon::createFromFormat($format, $dateString);
        } else {
            $fechaActual = Carbon::now();
            $year = Carbon::now()->year;

            $numeroSemana = $fechaActual->isoWeek() + $dto->add;
            $weekCarbon = Carbon::now()->setISODate($year, $numeroSemana)->startOfWeek();

            $numeroSemana = $numeroSemana > 52 ? 1 : $numeroSemana;

            $week = $this->getWeek->handle(GetWeekData::validateAndCreate([
                'week' => $numeroSemana,
                'year' => $year,
            ]));
        }

        $data = [];
        $data['week_id'] = $week->id;
        $data['week_programmed'] = $week->programmed;
        $data['week_number'] = $numeroSemana;
        $data['monday'] = $weekCarbon->format('Y-m-d');
        $data['tuesday'] = $weekCarbon->copy()->addDay()->format('Y-m-d');
        $data['wednesday'] = $weekCarbon->copy()->addDays(2)->format('Y-m-d');
        $data['thursday'] = $weekCarbon->copy()->addDays(3)->format('Y-m-d');
        $data['friday'] = $weekCarbon->copy()->addDays(4)->format('Y-m-d');

        return $data;
    }
}
