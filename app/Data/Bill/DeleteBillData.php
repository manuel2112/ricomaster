<?php

namespace App\Data\Bill;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class DeleteBillData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $week_id,
        #[Required, IntegerType]
        public int $type_menu_id,
        #[Required, StringType]
        public string $day,
    ) {
    }
}
