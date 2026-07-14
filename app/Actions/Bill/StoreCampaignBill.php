<?php

namespace App\Actions\Bill;

use App\Data\Bill\StoreCampaignBillData;
use App\Models\Bill;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreCampaignBill
{
    use AsAction;

    public function handle(StoreCampaignBillData $dto): void
    {

        $bill = Bill::where('menu_id', $dto->menu_id)
            ->where('campaign_id', $dto->campaign_id)
            ->first();

        if ($bill) {
            $bill->counter = $dto->counter;
            $bill->price = $dto->price;
            $bill->save();

            return;
        }

        Bill::create($dto->toArray());
    }
}
