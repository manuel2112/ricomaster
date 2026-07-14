<?php

namespace App\Actions\Menu;

use App\Data\Menu\UpdateMenuData;
use App\Models\Menu;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateMenu
{
    use AsAction;

    public function handle(UpdateMenuData $dto): void
    {
        $menu = Menu::find($dto->id);

        if ($menu) {

            $data = $dto->toArray();
            foreach ($data as $key => $value) {
                if ($value !== null) {
                    $menu->$key = $value;
                }
            }

            $menu->save();
        }
    }
}
