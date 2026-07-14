<?php

namespace App\Actions\GroupMenu;

use App\Data\GroupMenu\DeleteGroupMenuData;
use App\Models\GroupMenu;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteGroupMenu
{
    use AsAction;

    public function handle(DeleteGroupMenuData $dto): void
    {
        GroupMenu::where('menu_id', $dto->menu_id)->delete();
    }
}
