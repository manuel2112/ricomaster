<?php

namespace App\Data\Week;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;

class DaysWeekData extends Data
{
    public function __construct(
        #[IntegerType]
        public ?int $add = 0,
        #[IntegerType]
        public ?int $week = null,
        #[IntegerType]
        public ?int $id = null,
    ) {
    }
}
