<?php

namespace App\Data\Order;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class StoreAssociatedOrderData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $associated_id,
        #[Required, IntegerType]
        public int $menu_id,
        #[Required, IntegerType]
        public int $count,
        #[Required, IntegerType]
        public int $bill_id,
        #[Required, IntegerType]
        public int $price,
        #[Required, StringType]
        public string $day_order,
        #[Required, IntegerType]
        public int $order_number,
        #[Required, IntegerType]
        public int $type_menu_id,
    ) {}
}
