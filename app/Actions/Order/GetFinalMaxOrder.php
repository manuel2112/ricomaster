<?php

namespace App\Actions\Order;

use App\Models\OrderFinal;
use Lorisleiva\Actions\Concerns\AsAction;

class GetFinalMaxOrder
{
    use AsAction;

    public function handle(): int
    {
        return OrderFinal::max('order_number') ?? 0;
    }
}
