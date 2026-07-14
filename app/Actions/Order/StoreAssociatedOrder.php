<?php

namespace App\Actions\Order;

use App\Data\Order\StoreAssociatedOrderData;
use App\Models\Bill;
use App\Models\OrderAssociated;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreAssociatedOrder
{
    use AsAction;

    public function handle(StoreAssociatedOrderData $dto): void
    {
        OrderAssociated::create([
            'associated_id' => $dto->associated_id,
            'menu_id' => $dto->menu_id,
            'count' => $dto->count,
            'price' => $dto->price,
            'day_order' => $dto->day_order,
            'order_number' => $dto->order_number,
            'type_menu_id' => $dto->type_menu_id,
        ]);

        $bill = Bill::where('id', $dto->bill_id)->first();

        if ($bill) {
            $bill->counter = $bill->counter - $dto->count;
            $bill->save();
        }
    }
}
