<?php

namespace App\Data\Whatsapp;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class StoreWhatsappData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $type_client,
        #[Required, StringType]
        public string $message,
    ) {}
}
