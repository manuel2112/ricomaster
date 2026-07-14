<?php

namespace App\Actions\Bill;

use App\Data\Bill\GetWeekBillData;
use App\Models\Bill;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetWeekBill
{
    use AsAction;

    private Builder $builder;

    public function handle(GetWeekBillData $dto): Collection|LengthAwarePaginator
    {
        return $this->prepareQuery($dto->week_id)
            ->loadRelations($dto->relations)
            ->get();
    }

    protected function prepareQuery(int $weekId): self
    {
        $this->builder = Bill::query()
            ->where('week_id', $weekId);

        return $this;
    }

    protected function loadRelations(array $relations): self
    {
        $this->builder->with($relations);

        return $this;
    }

    protected function get(): Collection|LengthAwarePaginator
    {
        return $this->builder->get();
    }
}
