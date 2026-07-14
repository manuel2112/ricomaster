<?php

namespace App\Data\GroupMenu;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class StoreGroupMenuData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $menu_id,
        #[Required, ArrayType]
        public array $types
    ) {
    }
}
