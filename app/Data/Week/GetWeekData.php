<?php

namespace App\Data\Week;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class GetWeekData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $week,
        #[Required, IntegerType]
        public int $year,
    ) {
    }
}
