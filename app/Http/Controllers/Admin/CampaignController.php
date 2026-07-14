<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Bill\GetCampaignBill;
use App\Actions\Bill\ListCampaignBill;
use App\Actions\Campaign\GetCampaign;
use App\Actions\Campaign\GetCampaignAssociated;
use App\Actions\Campaign\GetCampaignToday;
use App\Actions\Parameter\GetParameter;
use App\Data\Bill\ListCampaignBillData;
use App\Http\Controllers\Controller;
use App\Utils\ResponseHandler;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function __construct(
        private readonly ListCampaignBill $listCampaignBill,
        private readonly GetCampaign $getCampaign,
        private readonly GetCampaignAssociated $getCampaignAssociated,
        private readonly GetCampaignBill $getCampaignBill,
        private readonly GetCampaignToday $getCampaignToday,
        private readonly GetParameter $getParameter,
    ) {}

    public function get(): View
    {
        return view('admin.campaign');
    }

    public function orderDetail(): View
    {
        return view('admin.campaign-orders-day');
    }

    public function listCampaigns(): JsonResponse
    {
        try {

            $data = [
                'today' => Carbon::now()->format('Y-m-d'),
                'campaigns' => $this->listCampaignBill->handle(ListCampaignBillData::validateAndCreate([])),
                'parameters' => $this->getParameter->handle(),
            ];

            return ResponseHandler::success($data, 'Campañas listado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function getCampaign(int $campaignId): JsonResponse
    {
        try {

            $data = [
                'campaign' => $this->getCampaign->handle($campaignId),
                'associateds' => $this->getCampaignAssociated->handle($campaignId),
                'bill' => $this->getCampaignBill->handle($campaignId),
            ];

            return ResponseHandler::success($data, 'Campaña detalle');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function getCampaignToday(): JsonResponse
    {
        try {

            $campaign = $this->getCampaignToday->handle();

            $data = [
                'today' => Carbon::now()->format('Y-m-d'),
                'campaign' => $campaign ? $campaign : null,
                'associateds' => $campaign ? $this->getCampaignAssociated->handle($campaign->id) : [],
                'bill' => $campaign ? $this->getCampaignBill->handle($campaign->id) : [],
                'isActive' => $this->isActiveCampaign(),
            ];

            return ResponseHandler::success($data, 'Campaña Hoy');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function isActiveCampaign(): bool
    {
        $now = Carbon::now();
        $parameters = $this->getParameter->handle();
        $startHour = Carbon::parse($parameters->campaign_hour_start)->format('H');
        $startMinute = Carbon::parse($parameters->campaign_hour_start)->format('i');
        $endHour = Carbon::parse($parameters->campaign_hour_end)->format('H');
        $endMinute = Carbon::parse($parameters->campaign_hour_end)->format('i');

        $start = $now->copy()->subDay()->setHour($startHour)->setMinute($startMinute)->setSecond(0);
        $end = $now->copy()->setHour($endHour)->setMinute($endMinute)->setSecond(0);

        return $now->isAfter($start) && $now->isBefore($end);
    }
}
