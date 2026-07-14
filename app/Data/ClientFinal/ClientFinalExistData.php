<?php

namespace App\Data\ClientFinal;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class ClientFinalExistData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $whatsapp,
        #[Required, IntegerType]
        public int $associated_id,
        #[Required, StringType]
        public string $name
    ) {
    }
}
