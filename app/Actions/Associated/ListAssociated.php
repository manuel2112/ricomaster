<?php

namespace App\Actions\Associated;

use App\Data\Associated\ListAssociatedData;
use App\Models\Associated;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ListAssociated
{
    use AsAction;

    private Builder $builder;

    public function handle(ListAssociatedData $dto): Collection|LengthAwarePaginator
    {
        return $this->prepareQuery($dto)
            ->loadRelations($dto->relations)
            ->get($dto->paginated, $dto->per_page);
    }

    protected function prepareQuery(ListAssociatedData $dto): self
    {
        $this->builder = Associated::query()
            ->whereNull('deleted_at')
            ->when(
                $dto->filter,
                fn (Builder $query) => $query->select('id', 'name', 'address', 'commune', 'map', 'whatsapp', 'menu_normal_final', 'menu_special_final')
            )->orderBy($dto->orderBy, $dto->orderByOrder);

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
