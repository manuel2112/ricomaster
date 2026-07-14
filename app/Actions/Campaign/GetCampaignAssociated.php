<?php

namespace App\Actions\Campaign;

use App\Models\AssociatedCampaign;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCampaignAssociated
{
    use AsAction;

    public function handle(int $campaignId): Collection
    {
        return AssociatedCampaign::where('campaign_id', $campaignId)->with('associated')->get();
    }
}
