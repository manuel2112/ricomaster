<?php

namespace App\Actions\Associated;

use App\Data\Associated\SearchAssociatedData;
use App\Models\Associated;
use Lorisleiva\Actions\Concerns\AsAction;

class SearchAssociated
{
    use AsAction;

    public function handle(SearchAssociatedData $dto): ?Associated
    {
        return Associated::where('rut', $dto->rut)->whereNull('deleted_at')->first();
    }
}
