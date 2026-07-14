<?php

namespace App\Data\Week;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;
use Symfony\Contracts\Service\Attribute\Required;

class ScheduleWeekExistData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $week,
        #[Required, IntegerType]
        public int $year,
    ) {}
}
