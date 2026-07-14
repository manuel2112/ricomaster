<?php

namespace App\Actions\Whatsapp;

use App\Data\Whatsapp\StoreWhatsappClientData;
use App\Models\WhatsappClient;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreWhatsappClient
{
    use AsAction;

    public function handle(StoreWhatsappClientData $dto): void
    {
        foreach ($dto->clients as $client) {
            WhatsappClient::create([
                'whatsapp_id' => $dto->whatsapp_id,
                'client_id' => $client,
            ]);
        }
    }
}
