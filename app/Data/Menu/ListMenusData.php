<?php

namespace App\Data\Menu;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class ListMenusData extends Data
{
    public function __construct(
        #[Required, BooleanType]
        public bool $paginated = false,
        #[Required, IntegerType]
        public int $per_page = 25,
        #[Required, ArrayType]
        public array $relations = [],
    ) {
    }
}
