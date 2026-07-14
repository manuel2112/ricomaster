<?php

namespace App\Actions\Associated;

use App\Data\Associated\UpdateAssociatedData;
use App\Models\Associated;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAssociated
{
    use AsAction;

    public function handle(UpdateAssociatedData $dto): void
    {
        $associated = Associated::find($dto->id);

        if ($associated) {

            $data = $dto->toArray();
            foreach ($data as $key => $value) {
                if ($value !== null) {
                    $associated->$key = $value;
                }
            }

            $associated->save();
        }
    }
}
