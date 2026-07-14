<?php

namespace App\Actions\Bill;

use App\Data\Bill\GetWeekBillData;
use App\Models\Bill;
use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class CheckIsActiveBill
{
    use AsAction;

    public function handle(GetWeekBillData $dto): void
    {
        Bill::where('week_id', $dto->week_id)->update(['is_active' => false]);

        $bills = Bill::where('week_id', $dto->week_id)->get();

        $dt = Carbon::now();
        $dayNumber = $dt->dayOfWeekIso;

        foreach ($bills as $bill) {
            if ($bill->day_number === $dayNumber && $bill->menu_id != 1 && $this->isBetween($dt)) {
                Bill::where('id', $bill->id)->update(['is_active' => true]);
            }
        }
    }

    public function isBetween(Carbon $date): bool
    {
        $startTime = $date->copy()->setHours(00)->setMinutes(00);
        $endTime = $date->copy()->setHours(10)->setMinutes(30);

        return $date->between($startTime, $endTime);
    }
}
