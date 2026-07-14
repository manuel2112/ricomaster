<?php

namespace App\Actions\Order;

use App\Models\OrderAssociated;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAssociatedMaxOrder
{
    use AsAction;

    public function handle(): int
    {
        return OrderAssociated::max('order_number') ?? 0;
    }
}
