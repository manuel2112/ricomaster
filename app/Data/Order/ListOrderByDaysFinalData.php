<?php

namespace App\Data\Order;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class ListOrderByDaysFinalData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $order_number,
        #[Required, BooleanType]
        public bool $paginated = false,
        #[Required, IntegerType]
        public int $per_page = 25,
        #[Required, ArrayType]
        public array $relations = [],
    ) {}
}
