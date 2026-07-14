<?php

namespace App\Data\Whatsapp;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class StoreWhatsappClientData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $whatsapp_id,
        #[Required, ArrayType]
        public array $clients,
    ) {}
}
