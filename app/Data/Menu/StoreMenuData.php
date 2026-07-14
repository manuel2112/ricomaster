<?php

namespace App\Data\Menu;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class StoreMenuData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $cod,
        #[Required, StringType]
        public string $name,
        #[StringType]
        public ?string $image,
    ) {
    }
}
