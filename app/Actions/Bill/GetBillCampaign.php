<?php

namespace App\Actions\Bill;

use App\Models\Bill;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBillCampaign
{
    use AsAction;

    public function handle(int $campaignId): Collection
    {
        return Bill::where('campaign_id', $campaignId)
            ->with(['menu', 'typeMenu'])
            ->get();
    }
}
