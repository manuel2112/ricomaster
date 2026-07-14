<?php

namespace App\Data\Campaign;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;
use Symfony\Contracts\Service\Attribute\Required;

class CampaignAssociatedStoreData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $campaign_id,
        #[Required, ArrayType]
        public array $associateds,
    ) {}
}
