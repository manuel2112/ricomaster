<?php

namespace App\Actions\GroupMenu;

use App\Data\GroupMenu\DeleteGroupMenuData;
use App\Data\GroupMenu\StoreGroupMenuData;
use App\Models\GroupMenu;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreGroupMenu
{
    use AsAction;

    public function __construct(
        private readonly DeleteGroupMenu $deleteGroupMenu,
    ) {
    }

    public function handle(StoreGroupMenuData $dto): void
    {
        $this->deleteGroupMenu->handle(DeleteGroupMenuData::validateAndCreate([
            'menu_id' => $dto->menu_id,
        ]));

        foreach ($dto->types as $type) {
            $group = new GroupMenu();
            $group->menu_id = $dto->menu_id;
            $group->type_menu_id = $type;
            $group->save();
        }
    }
}
