<?php

namespace App\Actions\Bill;

use App\Data\Bill\DeleteBillData;
use App\Models\Bill;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteBill
{
    use AsAction;

    public function handle(DeleteBillData $dto): void
    {
        Bill::where('week_id', $dto->week_id)
            ->where('type_menu_id', $dto->type_menu_id)
            ->where('day', $dto->day)
            ->delete();
    }
}
