<?php

namespace App\Actions\Order;

use App\Data\Order\ListOrderByDaysFinalData;
use App\Models\OrderAssociated;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAssociatedByNumberOrder
{
    use AsAction;

    private Builder $builder;

    public function handle(ListOrderByDaysFinalData $dto): Collection|LengthAwarePaginator
    {
        return $this->prepareQuery($dto)
            ->loadRelations($dto->relations)
            ->get($dto->paginated, $dto->per_page);
    }

    protected function prepareQuery(ListOrderByDaysFinalData $dto): self
    {
        $this->builder = OrderAssociated::query()
            ->where('order_number', $dto->order_number);

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
