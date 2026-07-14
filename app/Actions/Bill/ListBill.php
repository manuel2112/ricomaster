<?php

namespace App\Actions\Bill;

use App\Data\Bill\ListBillData;
use App\Models\Week;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ListBill
{
    use AsAction;

    private Builder $builder;

    public function handle(ListBillData $dto): Collection|LengthAwarePaginator
    {
        return $this->prepareQuery()
            ->loadRelations($dto->relations)
            ->get($dto->paginated, $dto->per_page);
    }

    protected function prepareQuery(): self
    {
        $this->builder = Week::query()
            ->where('is_past', true)
            ->orWhere('actual', true)
            ->orWhere('programmed', true)
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
