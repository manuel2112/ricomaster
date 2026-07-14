<?php

namespace App\Actions\Parameter;

use App\Data\Parameter\StoreParameterData;
use App\Models\Parameter;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreParameter
{
    use AsAction;

    public function handle(StoreParameterData $dto): Parameter
    {
        $parameter = Parameter::where('id', 1)->first();
        if ($parameter) {
            $parameter->bill_counter_default = $dto->bill_counter_default;
            $parameter->campaign_price_default = $dto->campaign_price_default;
            $parameter->campaign_counter_default = $dto->campaign_counter_default;
            $parameter->bill_hour_start = $dto->bill_hour_start;
            $parameter->bill_hour_end = $dto->bill_hour_end;
            $parameter->campaign_hour_start = $dto->campaign_hour_start;
            $parameter->campaign_hour_end = $dto->campaign_hour_end;
            $parameter->save();
        }

        return $parameter;
    }
}
