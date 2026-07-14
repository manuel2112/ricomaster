<?php

namespace App\Actions\Order;

use App\Data\Order\GetFinalByDayOrderData;
use App\Models\OrderAssociated;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class GetAssociatedByDayOrder
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
        $this->builder = OrderAssociated::query()
            ->where('day_order', $dto->day_order);

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
