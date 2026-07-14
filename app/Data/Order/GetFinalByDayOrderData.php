<?php

namespace App\Data\Order;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class GetFinalByDayOrderData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $day_order,
        #[Required, BooleanType]
        public bool $paginated = false,
        #[Required, IntegerType]
        public int $per_page = 25,
        #[Required, ArrayType]
        public array $relations = [],
        #[Required, IntegerType]
        public int $is_campaign = 0,
    ) {}
}
