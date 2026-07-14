<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Bill\CheckIsActiveBill;
use App\Actions\Bill\GetBillCampaign;
use App\Actions\Bill\GetCampaignBill;
use App\Actions\Bill\GetMinutaDayBill;
use App\Actions\Bill\GetMinutaTodayBill;
use App\Actions\Bill\GetWeekBill;
use App\Actions\Bill\ListBill;
use App\Actions\Bill\StoreBill;
use App\Actions\Bill\StoreCampaignBill;
use App\Actions\Campaign\CampaignAssociatedStore;
use App\Actions\Campaign\CampaignStore;
use App\Actions\Campaign\GetCampaign;
use App\Actions\Campaign\GetCampaignAssociated;
use App\Actions\Menu\ListMenus;
use App\Actions\Parameter\GetParameter;
use App\Actions\TypeMenu\ListTypeMenu;
use App\Actions\Week\CreateWeek;
use App\Actions\Week\DaysWeek;
use App\Actions\Week\GetActualWeek;
use App\Actions\Week\SailIsActive;
use App\Actions\Week\ScheduleWeek;
use App\Actions\Week\ScheduleWeekExist;
use App\Actions\Week\UpdateWeek;
use App\Data\Bill\GetWeekBillData;
use App\Data\Bill\ListBillData;
use App\Data\Bill\StoreBillData;
use App\Data\Bill\StoreCampaignBillData;
use App\Data\Campaign\CampaignAssociatedStoreData;
use App\Data\Menu\ListMenusData;
use App\Data\Week\DaysWeekData;
use App\Data\Week\ScheduleWeekExistData;
use App\Data\Week\UpdateWeekData;
use App\Http\Controllers\Controller;
use App\Utils\ResponseHandler;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillController extends Controller
{
    public function __construct(
        private readonly CreateWeek $createWeek,
        private readonly DaysWeek $daysWeek,
        private readonly ListTypeMenu $listTypeMenu,
        private readonly ListMenus $listMenus,
        private readonly StoreBill $storeBill,
        private readonly GetWeekBill $getWeekBill,
        private readonly UpdateWeek $updateWeek,
        private readonly GetActualWeek $getActualWeek,
        private readonly ScheduleWeek $scheduleWeek,
        private readonly CheckIsActiveBill $checkIsActiveBill,
        private readonly ListBill $listBill,
        private readonly SailIsActive $sailIsActive,
        private readonly GetMinutaDayBill $getMinutaDayBill,
        private readonly GetMinutaTodayBill $getMinutaTodayBill,
        private readonly CampaignStore $campaignStore,
        private readonly CampaignAssociatedStore $campaignAssociatedStore,
        private readonly StoreCampaignBill $storeCampaignBill,
        private readonly GetBillCampaign $getBillCampaign,
        private readonly GetCampaign $getCampaign,
        private readonly GetCampaignAssociated $getCampaignAssociated,
        private readonly GetCampaignBill $getCampaignBill,
        private readonly GetParameter $getParameter,
        private readonly ScheduleWeekExist $scheduleWeekExist,
    ) {}

    public function get(): View
    {
        $this->createWeek->handle();

        return view('admin.bill');
    }

    public function create(int $type): View
    {
        return view('admin.bill-create', [
            'type' => $type,
        ]);
    }

    public function edit(): View
    {
        return view('admin.bill-edit');
    }

    public function getBill(int $id): JsonResponse
    {
        try {
            $data = [];
            $week = $this->daysWeek->handle(DaysWeekData::validateAndCreate([
                'id' => $id,
            ]));
            $data['week'] = $week;
            $data['types'] = $this->listTypeMenu->handle();
            $data['select'] = $this->getWeekBill->handle(GetWeekBillData::validateAndCreate([
                'week_id' => $week['week_id'],
                'relations' => ['menu'],
            ]));

            return ResponseHandler::success($data, 'Minuta get');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function listBill(): JsonResponse
    {
        try {
            return ResponseHandler::success($this->listBill->handle(ListBillData::validateAndCreate([])), 'Minuta listado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function nextBill(int $type = 1): JsonResponse
    {
        try {
            $data = [];
            $week = $this->daysWeek->handle(DaysWeekData::validateAndCreate([
                'add' => $type == 1 ? 1 : 0,
            ]));
            $data['week'] = $week;
            $data['types'] = $this->listTypeMenu->handle();
            $data['menu'] = $this->listMenus->handle(ListMenusData::validateAndCreate([
                'relations' => ['types'],
            ]));
            $data['select'] = $this->getWeekBill->handle(GetWeekBillData::validateAndCreate([
                'week_id' => $week['week_id'],
                'relations' => ['menu'],
            ]));
            $data['parameters'] = $this->getParameter->handle();

            $fechaActual = Carbon::now();
            $year = Carbon::now()->year;
            $actualWeek = $fechaActual->isoWeek();
            $data['existWeek'] = $this->scheduleWeekExist->handle(ScheduleWeekExistData::validateAndCreate([
                'week' => $actualWeek,
                'year' => $year,
            ]));

            return ResponseHandler::success($data, 'Próxima minuta');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function getBillById(int $id): JsonResponse
    {
        try {
            $data = [];
            $week = $this->daysWeek->handle(DaysWeekData::validateAndCreate([
                'id' => $id,
            ]));
            $data['week'] = $week;
            $data['types'] = $this->listTypeMenu->handle();
            $data['menu'] = $this->listMenus->handle(ListMenusData::validateAndCreate([
                'relations' => ['types'],
            ]));
            $data['select'] = $this->getWeekBill->handle(GetWeekBillData::validateAndCreate([
                'week_id' => $week['week_id'],
                'relations' => ['menu'],
            ]));

            return ResponseHandler::success($data, 'Minuta para editar');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function actualBill(): JsonResponse
    {
        try {
            // TODO: JOBS PARA ESTO
            $this->scheduleWeek->handle();

            $data = [];
            $week = $this->getActualWeek->handle();

            $data['week'] = $this->daysWeek->handle(DaysWeekData::validateAndCreate([
                'week' => $week->week,
            ]));

            // TODO: JOBS PARA ESTO
            $this->checkIsActiveBill->handle(GetWeekBillData::validateAndCreate([
                'week_id' => $week->id,
            ]));

            $data['bill'] = $this->getWeekBill->handle(GetWeekBillData::validateAndCreate([
                'week_id' => $week->id,
                'relations' => ['menu'],
            ]));

            return ResponseHandler::success($data, 'Actual minuta');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function minutaBill(): JsonResponse
    {
        try {
            // TODO: JOBS PARA ESTO
            $this->scheduleWeek->handle();

            $data = [];
            $data = [
                'isActive' => $this->sailIsActive->handle(),
                'menu' => $this->getMinutaDayBill->handle(),
            ];

            return ResponseHandler::success($data, 'Actual minuta');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function minutaBillToday(): JsonResponse
    {
        try {

            return ResponseHandler::success($this->getMinutaTodayBill->handle(), 'Actual minuta');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $date = Carbon::parse($request['day']);
            $day_number = $date->format('w');

            $this->storeBill->handle(StoreBillData::validateAndCreate([
                'week_id' => $request['week_id'],
                'type_menu_id' => $request['type_menu_id'],
                'menu_id' => $request['menu_id'],
                'day_number' => $day_number,
                'day' => $request['day'],
                'counter' => $request['counter'],
            ]));

            return ResponseHandler::success($this->getWeekBill->handle(GetWeekBillData::validateAndCreate([
                'week_id' => $request['week_id'],
                'relations' => ['menu'],
            ])), 'Minuta día guardado');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function storeCampaign(Request $request): JsonResponse
    {
        try {
            // CAMPAÑA
            $campaign = $this->campaignStore->handle();

            // CAMPAÑA ASOCIADOS
            $this->campaignAssociatedStore->handle(CampaignAssociatedStoreData::validateAndCreate([
                'campaign_id' => $campaign->id,
                'associateds' => $request['associateds'],
            ]));

            // MENUS
            $this->storeCampaignBill->handle(StoreCampaignBillData::validateAndCreate([
                'menu_id' => $request['menu_id'],
                'campaign_id' => $campaign->id,
                'counter' => $request['counter'],
                'price' => $request['price'],
            ]));

            $data = [
                'campaign' => $this->getCampaign->handle($campaign->id),
                'associateds' => $this->getCampaignAssociated->handle($campaign->id),
                'bill' => $this->getCampaignBill->handle($campaign->id),
            ];

            return ResponseHandler::success($data, 'Campaña del día');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {
            return ResponseHandler::success($this->updateWeek->handle(UpdateWeekData::validateAndCreate([
                'id' => $request['week_id'],
                'programmed' => true,
            ])), 'Minuta programada');
        } catch (\Throwable $th) {
            return ResponseHandler::error($th->getMessage(), 400);
        }
    }
}
