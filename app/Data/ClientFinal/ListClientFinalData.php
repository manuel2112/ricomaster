<?php

namespace App\Data\ClientFinal;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class ListClientFinalData extends Data
{
    public function __construct(
        #[Required, BooleanType]
        public bool $paginated = false,
        #[Required, IntegerType]
        public int $per_page = 25,
        #[Required, IntegerType]
        public int $limit = 100,
        #[Required, ArrayType]
        public array $relations = [],
        #[BooleanType]
        public ?bool $send = null,
    ) {}
}
