<?php

namespace App\Actions\Order;

use App\Data\Order\ListOrderByDaysFinalAssociatedData;
use App\Data\Order\ListOrderDaysData;
use Lorisleiva\Actions\Concerns\AsAction;

class FinalResumeByDay
{
    use AsAction;

    public function __construct(
        private readonly ListOrderByDaysFinalAssociated $listOrderByDaysFinalAssociated,
        private readonly GetFinalByDay $getFinalByDay,
    ) {
    }

    public function handle(ListOrderDaysData $dto): array
    {
        $orders = [];
        $finals = $this->listOrderByDaysFinalAssociated->handle(ListOrderDaysData::validateAndCreate([
            'date' => $dto->date,
            'relations' => ['client_final', 'associated', 'menu'],
        ]));
        foreach ($finals as $final) {
            $details = $this->getFinalByDay->handle(ListOrderByDaysFinalAssociatedData::validateAndCreate([
                'day' => $dto->date,
                'client_final_id' => $final->client_final_id,
                'associated_id' => $final->associated_id,
            ]));
            $order = new \stdClass();
            $order->count_menu_01 = 0;
            $order->count_menu_02 = 0;
            $order->count_menu_naturist = 0;
            $order->count_menu_special = 0;
            foreach ($details as $detail) {
                if ($detail->client_final_id === $final->client_final_id) {
                    $order->count_menu_01 += $detail->type_menu_id == 1 ? $detail->count : 0;
                    $order->count_menu_02 += $detail->type_menu_id == 2 ? $detail->count : 0;
                    $order->count_menu_naturist += $detail->type_menu_id == 3 ? $detail->count : 0;
                    $order->count_menu_special += $detail->type_menu_id == 4 ? $detail->count : 0;
                }
                $order->client_final_id = $final->client_final_id;
                $order->associated = $final->associated;
                $order->client_final = $final->client_final;
                $order->total_price = ($order->count_menu_01 + $order->count_menu_02 + $order->count_menu_naturist) * $final->associated->menu_normal_final + $order->count_menu_special * $final->associated->menu_special_final;
            }
            $orders[] = $order;
        }

        return $orders;
    }
}
