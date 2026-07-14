<?php

namespace App\Data\Associated;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class UpdateAssociatedData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $id,
        #[StringType]
        public ?string $cod,
        #[StringType]
        public ?string $name,
        #[StringType]
        public ?string $rut,
        #[StringType]
        public ?string $social_name,
        #[StringType]
        public ?string $address,
        #[StringType]
        public ?string $commune,
        #[StringType]
        public ?string $map,
        #[StringType]
        public ?string $whatsapp,
        #[IntegerType]
        public ?int $menu_normal_associated,
        #[IntegerType]
        public ?int $menu_special_associated,
        #[IntegerType]
        public ?int $menu_normal_final,
        #[IntegerType]
        public ?int $menu_special_final,
        #[StringType]
        public ?string $deleted_at,
        #[BooleanType]
        public ?bool $send,
    ) {}
}
