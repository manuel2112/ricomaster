<?php

namespace App\Data\Associated;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class SearchAssociatedData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $rut,
    ) {
    }
}
