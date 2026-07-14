<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ClientFinal\ListClientFinal;
use App\Actions\ClientFinal\UpdateClientFinal;
use App\Actions\ClientFinal\UpdateMountClientFinal;
use App\Data\ClientFinal\ListClientFinalData;
use App\Data\ClientFinal\UpdateClientFinalData;
use App\Http\Controllers\Controller;
use App\Utils\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientFinalController extends Controller
{
    public function __construct(
        private readonly ListClientFinal $listClientFinal,
        private readonly UpdateMountClientFinal $updateMountClientFinal,
        private readonly UpdateClientFinal $updateClientFinal,
    ) {}

    public function get(): View
    {
        return view('admin.final-orders');
    }

    public function whatsapp(): View
    {
        return view('admin.final-whatsapp');
    }

    public function orderDetail(): View
    {
        return view('admin.final-orders-day');
    }

    public function listClientFinal(Request $request): JsonResponse
    {
        try {
            $this->updateMountClientFinal->handle();

            if ($request->input('optMenu') == 'SI') {
                $send = true;
            } elseif ($request->input('optMenu') == 'NO') {
                $send = false;
            } else {
                $send = null;
            }

            return ResponseHandler::success($this->listClientFinal->handle(ListClientFinalData::validateAndCreate([
                'relations' => ['associated'],
                'limit' => 100,
                'send' => $send,
            ])), 'List clientes finales');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function updateClientFinal(Request $request): JsonResponse
    {
        try {
            $this->updateClientFinal->handle(UpdateClientFinalData::validateAndCreate([
                'id' => $request->input('id'),
                'send' => ! $request->input('send'),
            ]));

            return ResponseHandler::success($this->listClientFinal->handle(ListClientFinalData::validateAndCreate([
                'relations' => ['associated'],
                'limit' => 100,
                'send' => $request->input('send'),
            ])), 'List clientes finales');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }
}
