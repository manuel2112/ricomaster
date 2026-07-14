<?php

namespace App\Http\Controllers\Admin;

use App\Actions\GroupMenu\StoreGroupMenu;
use App\Actions\Menu\ListMenus;
use App\Actions\Menu\StoreMenu;
use App\Actions\Menu\UpdateMenu;
use App\Data\GroupMenu\StoreGroupMenuData;
use App\Data\Menu\ListMenusData;
use App\Data\Menu\StoreMenuData;
use App\Data\Menu\UpdateMenuData;
use App\Http\Controllers\Controller;
use App\Utils\ResponseHandler;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\File\File;

class MenuController extends Controller
{
    public function __construct(
        private readonly StoreMenu $storeMenu,
        private readonly ListMenus $listMenus,
        private readonly UpdateMenu $updateMenu,
        private readonly StoreGroupMenu $storeGroupMenu,
    ) {}

    public function get(Request $request): View
    {
        return view('admin.menu');
    }

    public function list(): JsonResponse
    {
        try {
            return ResponseHandler::success($this->listMenus->handle(ListMenusData::validateAndCreate([
                'relations' => ['types'],
            ])), 'Menú listado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $menuArr = $request['menu'];
            $image = isset($menuArr['image']) ? $this->storeImages($menuArr['image']) : null;
            $menu = $this->storeMenu->handle(StoreMenuData::validateAndCreate([
                'cod' => $menuArr['cod'],
                'name' => $menuArr['name'],
                'image' => $image,
            ]));
            $this->storeGroupMenu->handle(StoreGroupMenuData::validateAndCreate([
                'menu_id' => $menu->id,
                'types' => $request['typeMenu'],
            ]));

            return ResponseHandler::success($this->listMenus->handle(ListMenusData::validateAndCreate([
                'relations' => ['types'],
            ])), 'Menú guardado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $image = null;
            if ($request['newImage']) {
                $image = isset($request['image']) ? $this->storeImages($request['image']) : null;
            }

            $this->updateMenu->handle(UpdateMenuData::validateAndCreate([
                'id' => $request['id'],
                'cod' => $request['cod'],
                'name' => $request['name'],
                'image' => $image,
            ]));

            $this->storeGroupMenu->handle(StoreGroupMenuData::validateAndCreate([
                'menu_id' => $request['id'],
                'types' => $request['types'],
            ]));

            return ResponseHandler::success($this->listMenus->handle(ListMenusData::validateAndCreate([
                'relations' => ['types'],
            ])), 'Menú actualizado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->updateMenu->handle(UpdateMenuData::validateAndCreate([
                'id' => $id,
                'deleted_at' => Carbon::now()->toDateTimeString(),
            ]));

            return ResponseHandler::success(true, 'Menú Eliminado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function storeImages($image)
    {
        if ($image) {
            $base64File = $image;

            $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64File));

            $tmpFilePath = sys_get_temp_dir().'/'.Str::uuid()->toString();
            file_put_contents($tmpFilePath, $fileData);

            $tmpFile = new File($tmpFilePath);

            $file = new UploadedFile(
                $tmpFile->getPathname(),
                $tmpFile->getFilename(),
                $tmpFile->getMimeType(),
                0,
                true
            );

            return $file->store('menu', 'public');
        }
    }
}
