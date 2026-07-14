<?php

namespace App\Actions\Campaign;

use App\Models\Campaign;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCampaign
{
    use AsAction;

    public function handle(int $campaignId): Campaign
    {
        return Campaign::where('id', $campaignId)->first();
    }
}
