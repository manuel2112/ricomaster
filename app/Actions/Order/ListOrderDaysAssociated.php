<?php

namespace App\Actions\Order;

use App\Data\Order\ListOrderDaysData;
use App\Models\OrderAssociated;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ListOrderDaysAssociated
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
        $this->builder = OrderAssociated::query()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_day')
            ->distinct()
            ->orderBy('created_day', 'desc');

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
