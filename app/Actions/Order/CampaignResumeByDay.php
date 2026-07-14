<?php

namespace App\Actions\Order;

use App\Data\Order\ListOrderByDaysFinalAssociatedData;
use App\Data\Order\ListOrderDaysData;
use Lorisleiva\Actions\Concerns\AsAction;

class CampaignResumeByDay
{
    use AsAction;

    public function __construct(
        private readonly ListOrderByDaysCampaignFinalAssociated $listOrderByDaysCampaignFinalAssociated,
        private readonly GetFinalByDay $getFinalByDay,
    ) {}

    public function handle(ListOrderDaysData $dto): array
    {
        $orders = [];
        $finals = $this->listOrderByDaysCampaignFinalAssociated->handle(ListOrderDaysData::validateAndCreate([
            'date' => $dto->date,
            'relations' => ['client_final', 'associated', 'menu'],
        ]));
        foreach ($finals as $final) {
            $details = $this->getFinalByDay->handle(ListOrderByDaysFinalAssociatedData::validateAndCreate([
                'day' => $dto->date,
                'client_final_id' => $final->client_final_id,
                'associated_id' => $final->associated_id,
            ]));
            $order = new \stdClass;
            foreach ($details as $detail) {
                $order->client_final_id = $final->client_final_id;
                $order->associated = $final->associated;
                $order->client_final = $final->client_final;
                $order->menu = $detail->menu_id;
                $order->count = $detail->count;
                $order->price = $detail->price;
            }
            $orders[] = $order;
        }

        return $orders;
    }
}
