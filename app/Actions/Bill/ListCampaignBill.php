<?php

namespace App\Actions\Bill;

use App\Data\Bill\ListCampaignBillData;
use App\Models\Campaign;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ListCampaignBill
{
    use AsAction;

    private Builder $builder;

    public function handle(ListCampaignBillData $dto): Collection|LengthAwarePaginator
    {
        return $this->prepareQuery()
            ->loadRelations($dto->relations)
            ->get($dto->paginated, $dto->per_page);
    }

    protected function prepareQuery(): self
    {
        $this->builder = Campaign::query()
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc');

        return $this;
    }

    protected function loadRelations(array $relations): self
    {
        $this->builder->with($relations);

        return $this;
    }

    protected function get(bool $paginated, int $perPage): Collection|LengthAwarePaginator
    {
        return $paginated ? $this->builder->paginate($perPage) : $this->builder->get();
    }
}
