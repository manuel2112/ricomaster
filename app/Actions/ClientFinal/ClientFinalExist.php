<?php

namespace App\Actions\ClientFinal;

use App\Data\ClientFinal\ClientFinalExistData;
use App\Models\ClientFinal;
use Lorisleiva\Actions\Concerns\AsAction;

class ClientFinalExist
{
    use AsAction;

    public function handle(ClientFinalExistData $dto): ClientFinal
    {
        $client = ClientFinal::where('whatsapp', $dto->whatsapp)->first();

        if (! $client) {
            $client = ClientFinal::create($dto->toArray());
        } else {
            $client->name = $dto->name;
            $client->associated_id = $dto->associated_id;
            $client->save();
        }

        return $client;
    }
}
