<?php

namespace App\Actions\Order;

use App\Data\Order\ListOrderDaysData;
use App\Models\OrderFinal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ListOrderByDaysCampaignFinalAssociated
{
    use AsAction;

    private Builder $builder;

    public function handle(ListOrderDaysData $dto): Collection|LengthAwarePaginator
    {
        return $this->prepareQuery($dto)
            ->loadRelations($dto->relations)
            ->get($dto->paginated, $dto->per_page);
    }

    protected function prepareQuery(ListOrderDaysData $dto): self
    {
        $this->builder = OrderFinal::query()
            ->whereDate('day_order', $dto->date)
            ->whereNotNull('campaign_id')
            ->selectRaw('client_final_id, associated_id')
            ->distinct()
            ->groupBy('client_final_id', 'associated_id')
            ->orderBy('client_final_id', 'desc');

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
