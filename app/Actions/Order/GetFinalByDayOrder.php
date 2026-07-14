<?php

namespace App\Actions\Order;

use App\Data\Order\GetFinalByDayOrderData;
use App\Models\OrderFinal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetFinalByDayOrder
{
    use AsAction;

    private Builder $builder;

    public function handle(GetFinalByDayOrderData $dto): Collection|LengthAwarePaginator
    {
        return $this->prepareQuery($dto)
            ->loadRelations($dto->relations)
            ->get($dto->paginated, $dto->per_page);
    }

    protected function prepareQuery(GetFinalByDayOrderData $dto): self
    {
        $this->builder = OrderFinal::query()
            ->where('day_order', $dto->day_order);

        if ($dto->is_campaign) {
            $this->builder->whereNotNull('campaign_id');
        }

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
