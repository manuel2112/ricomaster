<?php

namespace App\Actions\Order;

use App\Data\Order\ListOrderByDaysFinalAssociatedData;
use App\Models\OrderFinal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetFinalByDay
{
    use AsAction;

    private Builder $builder;

    public function handle(ListOrderByDaysFinalAssociatedData $dto): Collection|LengthAwarePaginator
    {
        return $this->prepareQuery($dto)
            ->loadRelations($dto->relations)
            ->get($dto->paginated, $dto->per_page);
    }

    protected function prepareQuery(ListOrderByDaysFinalAssociatedData $dto): self
    {
        $this->builder = OrderFinal::query()
            ->where('associated_id', $dto->associated_id)
            ->where('client_final_id', $dto->client_final_id)
            ->where('day_order', $dto->day);

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
