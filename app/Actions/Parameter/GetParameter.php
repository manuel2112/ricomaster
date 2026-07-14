<?php

namespace App\Actions\Parameter;

use App\Models\Parameter;
use Lorisleiva\Actions\Concerns\AsAction;

class GetParameter
{
    use AsAction;

    public function handle(): Parameter
    {
        return Parameter::where('id', 1)->first();
    }
}
