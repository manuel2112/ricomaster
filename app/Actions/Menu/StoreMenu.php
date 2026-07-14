<?php

namespace App\Actions\Menu;

use App\Data\Menu\StoreMenuData;
use App\Models\Menu;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreMenu
{
    use AsAction;

    public function handle(StoreMenuData $dto): Menu
    {
        return Menu::create($dto->toArray());
    }
}
