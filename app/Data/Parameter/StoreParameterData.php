<?php

namespace App\Data\Parameter;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class StoreParameterData extends Data
{
    public function __construct(
        #[IntegerType]
        public ?int $bill_counter_default = null,
        #[IntegerType]
        public ?int $campaign_price_default = null,
        #[IntegerType]
        public ?int $campaign_counter_default = null,
        #[StringType]
        public ?string $bill_hour_start = null,
        #[StringType]
        public ?string $bill_hour_end = null,
        #[StringType]
        public ?string $campaign_hour_start = null,
        #[StringType]
        public ?string $campaign_hour_end = null,
    ) {}
}
