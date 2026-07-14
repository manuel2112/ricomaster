<?php

namespace App\Actions\Campaign;

use App\Models\Campaign;
use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCampaignToday
{
    use AsAction;

    public function handle(): ?Campaign
    {
        $today = Carbon::now()->format('Y-m-d');

        return Campaign::where('day', $today)->first();
    }
}
