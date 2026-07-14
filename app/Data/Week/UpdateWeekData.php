<?php

namespace App\Data\Week;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UpdateWeekData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $id,
        #[BooleanType]
        public ?bool $programmed = false,
    ) {
    }
}
