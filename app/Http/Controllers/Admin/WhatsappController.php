<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Whatsapp\StoreWhatsapp;
use App\Actions\Whatsapp\StoreWhatsappClient;
use App\Data\Whatsapp\StoreWhatsappClientData;
use App\Data\Whatsapp\StoreWhatsappData;
use App\Http\Controllers\Controller;
use App\Utils\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsappController extends Controller
{
    public function __construct(
        private readonly StoreWhatsapp $storeWhatsapp,
        private readonly StoreWhatsappClient $storeWhatsappClient,
    ) {}

    public function storeFinal(Request $request): JsonResponse
    {
        try {
            Log::info($request);
            $whatsapp = $this->storeWhatsapp->handle(StoreWhatsappData::validateAndCreate([
                'type_client' => 1,
                'message' => $request->input('message'),
            ]));

            $this->storeWhatsappClient->handle(StoreWhatsappClientData::validateAndCreate([
                'whatsapp_id' => $whatsapp->id,
                'clients' => $request->input('clients'),
            ]));

            return ResponseHandler::success(true, 'Whatsapp creado correctamente');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function storeAssociated(Request $request): JsonResponse
    {
        try {
            Log::info($request);
            $whatsapp = $this->storeWhatsapp->handle(StoreWhatsappData::validateAndCreate([
                'type_client' => 2,
                'message' => $request->input('message'),
            ]));

            $this->storeWhatsappClient->handle(StoreWhatsappClientData::validateAndCreate([
                'whatsapp_id' => $whatsapp->id,
                'clients' => $request->input('clients'),
            ]));

            return ResponseHandler::success(true, 'Whatsapp creado correctamente');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }
}
