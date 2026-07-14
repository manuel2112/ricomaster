<?php

namespace App\Actions\Order;

use App\Actions\Associated\ListAssociated;
use App\Data\Associated\ListAssociatedData;
use App\Data\Order\AssociatedResumeByDayData;
use App\Data\Order\ListOrderByDaysAssociatedData;
use Lorisleiva\Actions\Concerns\AsAction;

class AssociatedResumeByDay
{
    use AsAction;

    public function __construct(
        private readonly GetAssociatedByDay $getAssociatedByDay,
        private readonly ListAssociated $listAssociated,
    ) {}

    public function handle(AssociatedResumeByDayData $dto): array
    {
        $orders = [];
        $associateds = $this->listAssociated->handle(ListAssociatedData::validateAndCreate([
            'filter' => false,
        ]));

        foreach ($associateds as $associated) {
            $details = $this->getAssociatedByDay->handle(ListOrderByDaysAssociatedData::validateAndCreate([
                'day' => $dto->day,
                'associated_id' => $associated->id,
            ]));
            $order = new \stdClass;
            $order->count_menu_01 = 0;
            $order->count_menu_02 = 0;
            $order->count_menu_naturist = 0;
            $order->count_menu_special = 0;
            foreach ($details as $detail) {
                if ($detail->associated_id == $associated->id) {
                    $order->count_menu_01 += $detail->type_menu_id == 1 && $detail->associated_id == $associated->id ? $detail->count : 0;
                    $order->count_menu_02 += $detail->type_menu_id == 2 && $detail->associated_id == $associated->id ? $detail->count : 0;
                    $order->count_menu_naturist += $detail->type_menu_id == 3 && $detail->associated_id == $associated->id ? $detail->count : 0;
                    $order->count_menu_special += $detail->type_menu_id == 4 && $detail->associated_id == $associated->id ? $detail->count : 0;
                }
            }
            $order->total_price = ($order->count_menu_01 + $order->count_menu_02 + $order->count_menu_naturist) * $associated->menu_normal_associated + $order->count_menu_special * $associated->menu_special_associated;
            $order->associated = $associated;

            if ($order->total_price > 0) {
                $orders[] = $order;
            }
        }

        return $orders;
    }
}
