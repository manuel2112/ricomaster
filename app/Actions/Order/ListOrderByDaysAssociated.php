<?php

namespace App\Actions\Order;

use App\Data\Order\ListOrderDaysData;
use App\Models\OrderAssociated;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ListOrderByDaysAssociated
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
        $this->builder = OrderAssociated::query()
            ->whereDate('day_order', $dto->date)
            ->selectRaw('order_number, associated_id, SUM(count * price) as total_count')
            ->distinct()
            ->groupBy('order_number', 'associated_id')
            ->orderBy('order_number', 'desc');

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
