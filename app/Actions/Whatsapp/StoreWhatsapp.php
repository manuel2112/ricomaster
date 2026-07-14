<?php

namespace App\Actions\Whatsapp;

use App\Data\Whatsapp\StoreWhatsappData;
use App\Models\Whatsapp;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreWhatsapp
{
    use AsAction;

    public function handle(StoreWhatsappData $dto): Whatsapp
    {
        return Whatsapp::create($dto->toArray());
    }
}
