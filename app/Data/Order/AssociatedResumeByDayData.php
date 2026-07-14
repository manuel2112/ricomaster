<?php

namespace App\Data\Order;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class AssociatedResumeByDayData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $day,
    ) {
    }
}
