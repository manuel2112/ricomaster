<?php

namespace App\Actions\Campaign;

use App\Models\Campaign;
use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class CampaignStore
{
    use AsAction;

    public function handle(): Campaign
    {
        $today = Carbon::now()->format('Y-m-d');

        $campaign = Campaign::where('day', $today)->first();

        if (! $campaign) {
            $campaign = Campaign::create([
                'day' => $today,
            ]);
        }

        return $campaign;
    }
}
