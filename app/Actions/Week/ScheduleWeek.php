<?php

namespace App\Actions\Week;

use App\Models\Week;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class ScheduleWeek
{
    use AsAction;

    public function handle(): void
    {
        $dbWeek = Week::where('programmed', true)->orderBy('week', 'asc')->first();

        if (is_null($dbWeek)) {
            return;
        }

        if (Carbon::parse($dbWeek->first_day) < Carbon::now()) {

            Log::info($dbWeek);
            Week::where('actual', true)->update([
                'actual' => false,
                'is_past' => true,
            ]);
            Week::where('programmed', true)->update(['programmed' => false]);

            $dbWeek->actual = true;
            $dbWeek->save();

            return;
        }

        $fechaActual = Carbon::now();
        $year = Carbon::now()->year;

        $actualWeek = $fechaActual->isoWeek();
        $weekCarbon = Carbon::now()->setISODate($year, $actualWeek)->startOfWeek();
        $friday = $weekCarbon->copy()->addDays(4)->format('Y-m-d 15:00:00');
        $nextWeek = $actualWeek + 1;

        $nextWeek = $nextWeek > 52 ? 1 : $nextWeek;

        if ($fechaActual->greaterThanOrEqualTo(Carbon::parse($friday)) && ($dbWeek->week == $nextWeek)) {
            Log::info($fechaActual);
            Week::where('actual', true)->update([
                'actual' => false,
                'is_past' => true,
            ]);
            Week::where('programmed', true)->update(['programmed' => false]);

            $dbWeek->actual = true;
            $dbWeek->save();
        }
    }
}
