<?php

namespace App\Data\Associated;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class ListAssociatedData extends Data
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
        #[Required, BooleanType]
        public bool $filter = false,
        #[Required, StringType]
        public string $orderBy = 'name',
        #[Required, StringType]
        public string $orderByOrder = 'asc',
        #[BooleanType]
        public ?bool $send = null,
    ) {}
}
