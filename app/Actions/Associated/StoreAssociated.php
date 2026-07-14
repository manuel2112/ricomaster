<?php

namespace App\Actions\Associated;

use App\Data\Associated\StoreAssociatedData;
use App\Models\Associated;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreAssociated
{
    use AsAction;

    public function handle(StoreAssociatedData $dto): void
    {
        Associated::create($dto->toArray());
    }
}
