<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Order\AssociatedResumeByDay;
use App\Actions\Order\FinalResumeByDay;
use App\Actions\Order\GetAssociatedByNumberOrder;
use App\Actions\Order\GetCampaignByDay;
use App\Actions\Order\GetFinalByNumberOrder;
use App\Data\Order\AssociatedResumeByDayData;
use App\Data\Order\ListOrderByDaysCampaignData;
use App\Data\Order\ListOrderByDaysFinalData;
use App\Data\Order\ListOrderDaysData;
use App\Http\Controllers\Controller;
use PDF;

class ReportController extends Controller
{
    public function __construct(
        private readonly GetFinalByNumberOrder $getFinalByNumberOrder,
        private readonly GetAssociatedByNumberOrder $getAssociatedByNumberOrder,
        private readonly AssociatedResumeByDay $associatedResumeByDay,
        private readonly FinalResumeByDay $finalResumeByDay,
        private readonly GetCampaignByDay $getCampaignByDay,
    ) {}

    public function finalDetail(int $orderNumber, int $isCampaign = 0)
    {
        $data = [
            'order' => $this->getFinalByNumberOrder->handle(ListOrderByDaysFinalData::validateAndCreate([
                'order_number' => $orderNumber,
                'relations' => ['client_final', 'associated', 'menu', 'type_menu'],
            ])),
            'is_campaign' => $isCampaign,
        ];
        $pdf = PDF::chunkLoadView('<html-separator/>', 'pdf.final-detail', $data);

        return $pdf->stream('document.pdf');
    }

    public function associatedDetail(int $orderNumber)
    {
        $data = [
            'order' => $this->getAssociatedByNumberOrder->handle(ListOrderByDaysFinalData::validateAndCreate([
                'order_number' => $orderNumber,
                'relations' => ['associated', 'menu', 'type_menu'],
            ])),
        ];
        $pdf = PDF::chunkLoadView('<html-separator/>', 'pdf.associated-detail', $data);

        return $pdf->stream('document.pdf');
    }

    public function finalDetailDay(string $day)
    {
        $data = [
            'day' => $day,
            'orders' => $this->finalResumeByDay->handle(ListOrderDaysData::validateAndCreate([
                'date' => $day,
            ])),
        ];
        $pdf = PDF::chunkLoadView('<html-separator/>', 'pdf.final-detail-day', $data);

        return $pdf->stream('document.pdf');
    }

    public function campaignDetailDay(string $day)
    {
        $data = [
            'day' => $day,
            'orders' => $this->getCampaignByDay->handle(ListOrderByDaysCampaignData::validateAndCreate([
                'day' => $day,
                'relations' => ['associated', 'menu', 'client_final'],
            ])),
        ];
        $pdf = PDF::chunkLoadView('<html-separator/>', 'pdf.campaign-detail-day', $data);

        return $pdf->stream('document.pdf');
    }

    public function associatedDetailDay(string $day)
    {
        $data = [
            'day' => $day,
            'orders' => $this->associatedResumeByDay->handle(AssociatedResumeByDayData::validateAndCreate([
                'day' => $day,
            ])),
        ];
        $pdf = PDF::chunkLoadView('<html-separator/>', 'pdf.associated-detail-day', $data);

        return $pdf->stream('document.pdf');
    }

    public function formatMoney(int $value): string
    {
        try {
            return '$'.number_format($value, 0, ',', '.');
        } catch (\Throwable $th) {
            return $value;
        }

        return (string) $value;
    }
}
