<?php

namespace App\Actions\Bill;

use App\Data\Bill\GetMinutaBillData;
use App\Models\Bill;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMinutaBill
{
    use AsAction;

    public function handle(GetMinutaBillData $dto): Collection
    {
        $day = $dto->day;
        $menu = Bill::where('week_id', $dto->week_id)
            ->where('day', $day)
            ->orderBy('type_menu_id', 'asc')
            ->with($dto->relations)
            ->get();

        return $menu;
    }
}
