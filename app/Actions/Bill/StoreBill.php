<?php

namespace App\Actions\Bill;

use App\Data\Bill\DeleteBillData;
use App\Data\Bill\StoreBillData;
use App\Models\Bill;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreBill
{
    use AsAction;

    public function __construct(
        private readonly DeleteBill $deleteBill,
    ) {}

    public function handle(StoreBillData $dto): void
    {
        $this->deleteBill->handle(DeleteBillData::validateAndCreate([
            'week_id' => $dto->week_id,
            'type_menu_id' => $dto->type_menu_id,
            'day' => $dto->day,
        ]));

        Bill::create($dto->toArray());
    }
}
