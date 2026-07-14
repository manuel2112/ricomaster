<?php

namespace App\Actions\Campaign;

use App\Data\Campaign\CampaignAssociatedStoreData;
use App\Models\AssociatedCampaign;
use Lorisleiva\Actions\Concerns\AsAction;

class CampaignAssociatedStore
{
    use AsAction;

    public function handle(CampaignAssociatedStoreData $dto): void
    {
        AssociatedCampaign::where('campaign_id', $dto->campaign_id)->delete();

        foreach ($dto->associateds as $associatedId) {
            $campaign = AssociatedCampaign::where('campaign_id', $dto->campaign_id)
                ->where('associated_id', $associatedId)->first();

            if (! $campaign) {
                $campaign = new AssociatedCampaign;
                $campaign->campaign_id = $dto->campaign_id;
                $campaign->associated_id = $associatedId;
                $campaign->save();
            }
        }
    }
}
