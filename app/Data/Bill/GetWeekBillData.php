<?php

namespace App\Data\Bill;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class GetWeekBillData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $week_id,
        #[Required, ArrayType]
        public array $relations = [],
    ) {
    }
}
