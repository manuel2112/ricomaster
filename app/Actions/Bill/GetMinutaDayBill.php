<?php

namespace App\Actions\Bill;

use App\Actions\Parameter\GetParameter;
use App\Actions\Week\DaysWeek;
use App\Actions\Week\GetActualWeek;
use App\Data\Bill\GetMinutaBillData;
use App\Data\Week\DaysWeekData;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetMinutaDayBill
{
    use AsAction;

    public function __construct(
        private readonly DaysWeek $daysWeek,
        private readonly GetActualWeek $getActualWeek,
        private readonly GetMinutaBill $getMinutaBill,
        private readonly GetParameter $getParameter,
    ) {}

    public function handle(): array
    {
        $menu = [];
        $week = $this->getActualWeek->handle();

        $days = $this->daysWeek->handle(DaysWeekData::validateAndCreate([
            'week' => $week->week,
        ]));

        $week_id = $days['week_id'];
        $monday = $days['monday'];
        $tuesday = $days['tuesday'];
        $wednesday = $days['wednesday'];
        $thursday = $days['thursday'];
        $friday = $days['friday'];

        $strDay = 'Lunes';
        $day = Carbon::parse($monday)->format('d/m/Y');
        $active = $this->dayActive($monday);
        $menus = $this->getMinutaBill->handle(GetMinutaBillData::validateAndCreate([
            'week_id' => $week_id,
            'day' => $monday,
            'relations' => ['menu', 'typeMenu'],
        ]));
        $menu[] = [
            'day' => $day,
            'day_order' => $monday,
            'strDay' => $strDay,
            'active' => $active,
            'menus' => $menus,
            'is_holiday' => $this->fnHoliday($menus),
        ];
        $strDay = 'Martes';
        $day = Carbon::parse($tuesday)->format('d/m/Y');
        $active = $this->dayActive($tuesday);
        $menus = $this->getMinutaBill->handle(GetMinutaBillData::validateAndCreate([
            'week_id' => $week_id,
            'day' => $tuesday,
            'relations' => ['menu', 'typeMenu'],
        ]));
        $menu[] = [
            'day' => $day,
            'day_order' => $tuesday,
            'strDay' => $strDay,
            'active' => $active,
            'menus' => $menus,
            'is_holiday' => $this->fnHoliday($menus),
        ];
        $strDay = 'Miércoles';
        $day = Carbon::parse($wednesday)->format('d/m/Y');
        $active = $this->dayActive($wednesday);
        $menus = $this->getMinutaBill->handle(GetMinutaBillData::validateAndCreate([
            'week_id' => $week_id,
            'day' => $wednesday,
            'relations' => ['menu', 'typeMenu'],
        ]));
        $menu[] = [
            'day' => $day,
            'day_order' => $wednesday,
            'strDay' => $strDay,
            'active' => $active,
            'menus' => $menus,
            'is_holiday' => $this->fnHoliday($menus),
        ];
        $strDay = 'Jueves';
        $day = Carbon::parse($thursday)->format('d/m/Y');
        $active = $this->dayActive($thursday);
        $menus = $this->getMinutaBill->handle(GetMinutaBillData::validateAndCreate([
            'week_id' => $week_id,
            'day' => $thursday,
            'relations' => ['menu', 'typeMenu'],
        ]));
        $menu[] = [
            'day' => $day,
            'day_order' => $thursday,
            'strDay' => $strDay,
            'active' => $active,
            'menus' => $menus,
            'is_holiday' => $this->fnHoliday($menus),
        ];
        $strDay = 'Viernes';
        $day = Carbon::parse($friday)->format('d/m/Y');
        $active = $this->dayActive($friday);
        $menus = $this->getMinutaBill->handle(GetMinutaBillData::validateAndCreate([
            'week_id' => $week_id,
            'day' => $friday,
            'relations' => ['menu', 'typeMenu'],
        ]));
        $menu[] = [
            'day' => $day,
            'day_order' => $friday,
            'strDay' => $strDay,
            'active' => $active,
            'menus' => $menus,
            'is_holiday' => $this->fnHoliday($menus),
        ];

        return $menu;
    }

    public function dayActive(string $day): bool
    {
        $date = Carbon::parse($day);
        $now = Carbon::now();
        $parameters = $this->getParameter->handle();
        $startHour = Carbon::parse($parameters->bill_hour_start)->format('H');
        $startMinute = Carbon::parse($parameters->bill_hour_start)->format('i');
        $endHour = Carbon::parse($parameters->bill_hour_end)->format('H');
        $endMinute = Carbon::parse($parameters->bill_hour_end)->format('i');

        $dayNumber = $date->format('N'); // 1 (Monday) to 5 (Friday)

        if ($dayNumber == 1) { // Lunes
            $previous_15 = $date->copy()->subDays(3)->setHour($startHour)->setMinute($startMinute)->setSecond(0);
        } else {
            $previous_15 = $date->copy()->subDay()->setHour($startHour)->setMinute($startMinute)->setSecond(0);
        }

        $today_10 = $date->copy()->setHour($endHour)->setMinute($endMinute)->setSecond(0);

        return $now->isAfter($previous_15) && $now->isBefore($today_10);
    }

    public function fnHoliday(Collection $menus): bool
    {
        $isHoliday = true;

        foreach ($menus as $menu) {
            if ($menu->menu_id != 1) {
                $isHoliday = false;
                break;
            }
        }

        return $isHoliday;
    }
}
