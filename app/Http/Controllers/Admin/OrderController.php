<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ClientFinal\ClientFinalExist;
use App\Actions\Order\AssociatedResumeByDay;
use App\Actions\Order\CampaignResumeByDay;
use App\Actions\Order\FinalResumeByDay;
use App\Actions\Order\GetAssociatedByDayOrder;
use App\Actions\Order\GetAssociatedByNumberOrder;
use App\Actions\Order\GetAssociatedMaxOrder;
use App\Actions\Order\GetCampaignByDay;
use App\Actions\Order\GetFinalByDayOrder;
use App\Actions\Order\GetFinalByNumberOrder;
use App\Actions\Order\GetFinalMaxOrder;
use App\Actions\Order\ListAssociatedDaysOrders;
use App\Actions\Order\ListFinalDaysOrders;
use App\Actions\Order\ListOrderByDaysAssociated;
use App\Actions\Order\ListOrderByDaysFinal;
use App\Actions\Order\ListOrderDaysAssociated;
use App\Actions\Order\ListOrderDaysFinal;
use App\Actions\Order\StoreAssociatedOrder;
use App\Actions\Order\StoreClientFinalOrder;
use App\Data\ClientFinal\ClientFinalExistData;
use App\Data\Order\AssociatedResumeByDayData;
use App\Data\Order\GetFinalByDayOrderData;
use App\Data\Order\ListOrderByDaysCampaignData;
use App\Data\Order\ListOrderByDaysFinalData;
use App\Data\Order\ListOrderDaysData;
use App\Data\Order\StoreAssociatedOrderData;
use App\Data\Order\StoreClientFinalOrderData;
use App\Http\Controllers\Controller;
use App\Utils\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly StoreAssociatedOrder $storeAssociatedOrder,
        private readonly StoreClientFinalOrder $storeClientFinalOrder,
        private readonly ClientFinalExist $clientFinalExist,
        private readonly ListOrderDaysAssociated $listOrderDaysAssociated,
        private readonly ListOrderDaysFinal $listOrderDaysFinal,
        private readonly ListOrderByDaysFinal $listOrderByDaysFinal,
        private readonly ListFinalDaysOrders $listFinalDaysOrders,
        private readonly GetFinalMaxOrder $getFinalMaxOrder,
        private readonly GetAssociatedMaxOrder $getAssociatedMaxOrder,
        private readonly GetFinalByNumberOrder $getFinalByNumberOrder,
        private readonly GetFinalByDayOrder $getFinalByDayOrder,
        private readonly ListAssociatedDaysOrders $listAssociatedDaysOrders,
        private readonly ListOrderByDaysAssociated $listOrderByDaysAssociated,
        private readonly GetAssociatedByDayOrder $getAssociatedByDayOrder,
        private readonly GetAssociatedByNumberOrder $getAssociatedByNumberOrder,
        private readonly AssociatedResumeByDay $associatedResumeByDay,
        private readonly FinalResumeByDay $finalResumeByDay,
        private readonly CampaignResumeByDay $campaignResumeByDay,
        private readonly GetCampaignByDay $getCampaignByDay,
    ) {}

    public function storeAssociated(Request $request): JsonResponse
    {
        try {

            $orderNumber = $this->getAssociatedMaxOrder->handle() + 1;

            foreach ($request['order'] as $order) {
                if ($order && $order['count'] > 0) {
                    $this->storeAssociatedOrder->handle(StoreAssociatedOrderData::validateAndCreate([
                        'associated_id' => $request['associated']['id'],
                        'menu_id' => $order['menu_id'],
                        'count' => $order['count'],
                        'price' => $order['price'],
                        'day_order' => $request['day_order'],
                        'order_number' => $orderNumber,
                        'type_menu_id' => $order['type_menu_id'],
                        'bill_id' => $order['bill_id'],
                    ]));
                }
            }

            return ResponseHandler::success(true, 'Order asociado guardada');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function storeFinal(Request $request): JsonResponse
    {
        try {

            $client = $this->clientFinalExist->handle(ClientFinalExistData::validateAndCreate([
                'whatsapp' => '+56'.$request['client']['whatsapp'],
                'name' => $request['client']['name'],
                'associated_id' => $request['associated']['id'],
            ]));

            $orderNumber = $this->getFinalMaxOrder->handle() + 1;

            foreach ($request['order'] as $order) {
                if ($order && $order['count'] > 0) {
                    $this->storeClientFinalOrder->handle(StoreClientFinalOrderData::validateAndCreate([
                        'client_final_id' => $client->id,
                        'associated_id' => $request['associated']['id'],
                        'menu_id' => $order['menu_id'],
                        'count' => $order['count'],
                        'price' => $order['price'],
                        'day_order' => $request['day_order'],
                        'order_number' => $orderNumber,
                        'type_menu_id' => $order['type_menu_id'],
                        'bill_id' => $order['bill_id'],
                    ]));
                }
            }

            return ResponseHandler::success($client->id, 'Order final guardada');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function storeFinalCampaign(Request $request): JsonResponse
    {
        try {

            $client = $this->clientFinalExist->handle(ClientFinalExistData::validateAndCreate([
                'whatsapp' => '+56'.$request['client']['whatsapp'],
                'name' => $request['client']['name'],
                'associated_id' => $request['orders'][0]['associated_id'],
            ]));

            $orderNumber = $this->getFinalMaxOrder->handle() + 1;

            foreach ($request['orders'] as $order) {
                if ($order && $order['count'] > 0) {
                    $this->storeClientFinalOrder->handle(StoreClientFinalOrderData::validateAndCreate([
                        'client_final_id' => $client->id,
                        'associated_id' => $order['associated_id'],
                        'menu_id' => $order['menu_id'],
                        'count' => $order['count'],
                        'price' => $order['price'],
                        'day_order' => $request['day_order'],
                        'order_number' => $orderNumber,
                        'bill_id' => $order['bill_id'],
                        'campaign_id' => $order['campaign_id'],
                    ]));
                }
            }

            return ResponseHandler::success($client->id, 'Order final guardada');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function getDayOrder(): JsonResponse
    {
        try {
            $data = [];
            $data['daysAssociated'] = $this->listOrderDaysAssociated->handle(ListOrderDaysData::validateAndCreate([]));
            $data['daysFinal'] = $this->listOrderDaysFinal->handle(ListOrderDaysData::validateAndCreate([]));

            return ResponseHandler::success($data, 'Días de venta');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function getDayOrderDetailAssociated(string $day): JsonResponse
    {
        try {
            $data = [
                'ordersDay' => $this->listOrderByDaysAssociated->handle(ListOrderDaysData::validateAndCreate([
                    'date' => $day,
                    'relations' => ['associated', 'menu'],
                ])),
                'orders' => $this->associatedResumeByDay->handle(AssociatedResumeByDayData::validateAndCreate([
                    'day' => $day,
                ])),
            ];

            return ResponseHandler::success($data, 'Días de venta');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function getDayOrderDetailFinal(string $day, int $isCampaign = 0): JsonResponse
    {
        try {
            $data = [
                'ordersDay' => $this->listOrderByDaysFinal->handle(ListOrderDaysData::validateAndCreate([
                    'date' => $day,
                    'is_campaign' => $isCampaign,
                    'relations' => ['associated', 'menu', 'client_final'],
                ])),
                'orders' => $isCampaign ?
                    $this->getCampaignByDay->handle(ListOrderByDaysCampaignData::validateAndCreate([
                        'day' => $day,
                        'relations' => ['associated', 'menu', 'client_final'],
                    ])) :
                    $this->finalResumeByDay->handle(ListOrderDaysData::validateAndCreate([
                        'date' => $day,
                    ])),
            ];

            return ResponseHandler::success($data, 'Días de venta');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function getAssociatedOrders(): JsonResponse
    {
        try {

            return ResponseHandler::success($this->listAssociatedDaysOrders->handle(ListOrderDaysData::validateAndCreate([])), 'Días de venta asociados');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function getFinalOrders(): JsonResponse
    {
        try {

            return ResponseHandler::success($this->listFinalDaysOrders->handle(ListOrderDaysData::validateAndCreate([])), 'Días de venta');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function getOrderByAssociated(int $orderNumber): JsonResponse
    {
        try {
            return ResponseHandler::success($this->getAssociatedByNumberOrder->handle(ListOrderByDaysFinalData::validateAndCreate([
                'order_number' => $orderNumber,
                'relations' => ['associated', 'menu', 'type_menu'],
            ])), 'Pedidos por día de asociado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function getOrderByNumber(int $orderNumber): JsonResponse
    {
        try {

            return ResponseHandler::success($this->getFinalByNumberOrder->handle(ListOrderByDaysFinalData::validateAndCreate([
                'order_number' => $orderNumber,
                'relations' => ['client_final', 'associated', 'menu', 'type_menu'],
            ])), 'Pedidos por número de orden');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function getOrderAssociatedByDay(string $day): JsonResponse
    {
        try {
            $data = ($this->getAssociatedByDayOrder->handle(GetFinalByDayOrderData::validateAndCreate([
                'day_order' => $day,
                'relations' => ['associated', 'menu', 'type_menu'],
            ])));

            return ResponseHandler::success($data, 'Pedidos por día');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function getOrderFinalByDay(string $day, int $isCampaign = 0): JsonResponse
    {
        try {
            $data = ($this->getFinalByDayOrder->handle(GetFinalByDayOrderData::validateAndCreate([
                'day_order' => $day,
                'is_campaign' => $isCampaign,
                'relations' => ['client_final', 'associated', 'menu', 'type_menu'],
            ])));

            return ResponseHandler::success($data, 'Pedidos por día');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }
}
