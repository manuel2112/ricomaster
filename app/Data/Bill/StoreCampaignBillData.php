<?php

namespace App\Data\Bill;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class StoreCampaignBillData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $menu_id,
        #[Required, IntegerType]
        public int $campaign_id,
        #[Required, IntegerType]
        public int $counter = 0,
        #[Required, IntegerType]
        public int $price = 0,
    ) {}
}
