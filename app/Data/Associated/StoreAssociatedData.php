<?php

namespace App\Data\Associated;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class StoreAssociatedData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $cod,
        #[Required, StringType]
        public string $name,
        #[Required, StringType]
        public string $rut,
        #[Required, StringType]
        public string $social_name,
        #[Required, StringType]
        public string $address,
        #[Required, StringType]
        public string $commune,
        #[Required, StringType]
        public string $map,
        #[Required, StringType]
        public string $whatsapp,
        #[Required, IntegerType]
        public int $menu_normal_associated,
        #[Required, IntegerType]
        public int $menu_special_associated,
        #[Required, IntegerType]
        public int $menu_normal_final,
        #[Required, IntegerType]
        public int $menu_special_final,
    ) {
    }
}
