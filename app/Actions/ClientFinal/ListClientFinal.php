<?php

namespace App\Actions\ClientFinal;

use App\Data\ClientFinal\ListClientFinalData;
use App\Models\ClientFinal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ListClientFinal
{
    use AsAction;

    private Builder $builder;

    public function handle(ListClientFinalData $dto): Collection|LengthAwarePaginator
    {
        return $this->prepareQuery($dto)
            ->loadRelations($dto->relations)
            ->get($dto->paginated, $dto->per_page);
    }

    protected function prepareQuery(ListClientFinalData $dto): self
    {
        $this->builder = ClientFinal::query()
            ->whereNull('deleted_at')
            ->limit($dto->limit)
            ->orderBy('mount', 'desc');

        if (! is_null($dto->send)) {
            $this->builder->where('send', $dto->send);
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
