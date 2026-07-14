<?php

namespace App\Data\Bill;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class GetMinutaBillData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $week_id,
        #[Required, StringType]
        public string $day,
        #[Required, ArrayType]
        public array $relations = [],
    ) {}
}
