<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Parameter\GetParameter;
use App\Actions\Parameter\StoreParameter;
use App\Data\Parameter\StoreParameterData;
use App\Http\Controllers\Controller;
use App\Utils\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParameterController extends Controller
{
    public function __construct(
        private readonly GetParameter $getParameter,
        private readonly StoreParameter $storeParameter,
    ) {}

    public function get(): View
    {
        return view('admin.parameter');
    }

    public function getParameters(): JsonResponse
    {
        try {
            $parameters = $this->getParameter->handle();

            return ResponseHandler::success($parameters, 'Parametros obtenidos');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $parameters = $this->storeParameter->handle(StoreParameterData::validateAndCreate([
                'bill_counter_default' => $request->input('bill_counter_default'),
                'campaign_price_default' => $request->input('campaign_price_default'),
                'campaign_counter_default' => $request->input('campaign_counter_default'),
                'bill_hour_start' => $request->input('bill_hour_start'),
                'bill_hour_end' => $request->input('bill_hour_end'),
                'campaign_hour_start' => $request->input('campaign_hour_start'),
                'campaign_hour_end' => $request->input('campaign_hour_end'),
            ]));

            return ResponseHandler::success($parameters, 'Parametros guardados');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }
}
