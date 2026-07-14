<?php

namespace App\Data\Menu;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Symfony\Contracts\Service\Attribute\Required;

class UpdateMenuData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $id,
        #[StringType]
        public ?string $cod,
        #[StringType]
        public ?string $name,
        #[StringType]
        public ?string $image,
        #[StringType]
        public ?string $deleted_at,
    ) {
    }
}
