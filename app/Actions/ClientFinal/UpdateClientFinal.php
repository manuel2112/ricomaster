<?php

namespace App\Actions\ClientFinal;

use App\Data\ClientFinal\UpdateClientFinalData;
use App\Models\ClientFinal;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateClientFinal
{
    use AsAction;

    public function handle(UpdateClientFinalData $dto): void
    {
        $client = ClientFinal::find($dto->id);

        if ($client) {
            $client->send = $dto->send;
            $client->save();
        }
    }
}
