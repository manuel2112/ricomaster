<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Associated\ListAssociated;
use App\Actions\Associated\SearchAssociated;
use App\Actions\Associated\StoreAssociated;
use App\Actions\Associated\UpdateAssociated;
use App\Actions\Associated\UpdateMountAssociated;
use App\Data\Associated\ListAssociatedData;
use App\Data\Associated\SearchAssociatedData;
use App\Data\Associated\StoreAssociatedData;
use App\Data\Associated\UpdateAssociatedData;
use App\Http\Controllers\Controller;
use App\Utils\ResponseHandler;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssociatedController extends Controller
{
    public function __construct(
        private readonly ListAssociated $listAssociated,
        private readonly StoreAssociated $storeAssociated,
        private readonly UpdateAssociated $updateAssociated,
        private readonly SearchAssociated $searchAssociated,
        private readonly UpdateMountAssociated $updateMountAssociated,
    ) {}

    public function get(Request $request): View
    {
        return view('admin.associated');
    }

    public function order(Request $request): View
    {
        return view('admin.associated-orders');
    }

    public function whatsapp(Request $request): View
    {
        return view('admin.associated-whatsapp');
    }

    public function orderDetail(Request $request): View
    {
        return view('admin.associated-orders-day');
    }

    public function listAssociated(Request $request): JsonResponse
    {
        try {
            $this->updateMountAssociated->handle();

            if ($request->input('optMenu') == 'SI') {
                $send = true;
            } elseif ($request->input('optMenu') == 'NO') {
                $send = false;
            } else {
                $send = null;
            }

            return ResponseHandler::success($this->listAssociated->handle(ListAssociatedData::validateAndCreate([
                'filter' => false,
                'orderBy' => 'mount',
                'orderByOrder' => 'desc',
                'limit' => 100,
                'send' => $send,
            ])), 'Asociados listados');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function list(int $filter): JsonResponse
    {
        try {

            return ResponseHandler::success($this->listAssociated->handle(ListAssociatedData::validateAndCreate([
                'filter' => $filter,
            ])), 'Asociados listados');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $arr = $request['associated'];
            $this->storeAssociated->handle(StoreAssociatedData::validateAndCreate([
                'cod' => $arr['cod'],
                'name' => $arr['name'],
                'rut' => $arr['rut'],
                'social_name' => $arr['social_name'],
                'address' => $arr['address'],
                'commune' => $arr['commune'],
                'map' => $arr['map'],
                'whatsapp' => $arr['whatsapp'],
                'menu_normal_associated' => $arr['menu_normal_associated'],
                'menu_special_associated' => $arr['menu_special_associated'],
                'menu_normal_final' => $arr['menu_normal_final'],
                'menu_special_final' => $arr['menu_special_final'],
            ]));

            return ResponseHandler::success($this->listAssociated->handle(ListAssociatedData::validateAndCreate([])), 'Asociado guardado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function search(Request $request): JsonResponse
    {
        try {
            return ResponseHandler::success($this->searchAssociated->handle(SearchAssociatedData::validateAndCreate([
                'rut' => $request->post('rut'),
            ])), 'Asociado encontrado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $this->updateAssociated->handle(UpdateAssociatedData::validateAndCreate([
                'id' => $request['id'],
                'cod' => $request['cod'],
                'name' => $request['name'],
                'rut' => $request['rut'],
                'social_name' => $request['social_name'],
                'address' => $request['address'],
                'commune' => $request['commune'],
                'map' => $request['map'],
                'whatsapp' => $request['whatsapp'],
                'menu_normal_associated' => $request['menu_normal_associated'],
                'menu_special_associated' => $request['menu_special_associated'],
                'menu_normal_final' => $request['menu_normal_final'],
                'menu_special_final' => $request['menu_special_final'],
            ]));

            return ResponseHandler::success($this->listAssociated->handle(ListAssociatedData::validateAndCreate([])), 'Asociado actualizado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function updateWhatsapp(Request $request): JsonResponse
    {
        try {
            $this->updateAssociated->handle(UpdateAssociatedData::validateAndCreate([
                'id' => $request['id'],
                'send' => ! $request->input('send'),
            ]));

            return ResponseHandler::success($this->listAssociated->handle(ListAssociatedData::validateAndCreate([
                'send' => $request->input('send'),
            ])), 'Asociado actualizado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->updateAssociated->handle(UpdateAssociatedData::validateAndCreate([
                'id' => $id,
                'deleted_at' => Carbon::now()->toDateTimeString(),
            ]));

            return ResponseHandler::success($this->listAssociated->handle(ListAssociatedData::validateAndCreate([])), 'Asociado Eliminado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }
}
