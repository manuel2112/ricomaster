<?php

namespace App\Actions\Order;

use App\Data\Order\StoreClientFinalOrderData;
use App\Models\Bill;
use App\Models\OrderFinal;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreClientFinalOrder
{
    use AsAction;

    public function handle(StoreClientFinalOrderData $dto): void
    {
        OrderFinal::create([
            'client_final_id' => $dto->client_final_id,
            'associated_id' => $dto->associated_id,
            'menu_id' => $dto->menu_id,
            'count' => $dto->count,
            'price' => $dto->price,
            'day_order' => $dto->day_order,
            'order_number' => $dto->order_number,
            'type_menu_id' => $dto->type_menu_id,
            'campaign_id' => $dto->campaign_id,
        ]);

        $bill = Bill::where('id', $dto->bill_id)->first();

        if ($bill) {
            $bill->counter = $bill->counter - $dto->count;
            $bill->save();
        }
    }
}
