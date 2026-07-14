<?php

namespace App\Actions\Order;

use App\Data\Order\ListOrderDaysData;
use App\Models\OrderFinal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ListFinalDaysOrders
{
    use AsAction;

    private Builder $builder;

    public function handle(ListOrderDaysData $dto): Collection|LengthAwarePaginator
    {
        return $this->prepareQuery()
            ->loadRelations($dto->relations)
            ->get($dto->paginated, $dto->per_page);
    }

    protected function prepareQuery(): self
    {
        $this->builder = OrderFinal::query()
            ->selectRaw('day_order, DATE_FORMAT(day_order, "%d/%m/%Y") as created_day, count(distinct order_number) as total_orders')
            ->distinct()
            ->groupBy('day_order')
            ->orderBy('day_order', 'desc');

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
