<?php

namespace App\Actions\Menu;

use App\Data\Menu\ListMenusData;
use App\Models\Menu;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ListMenus
{
    use AsAction;

    private Builder $builder;

    public function handle(ListMenusData $dto): Collection|LengthAwarePaginator
    {
        return $this->prepareQuery()
            ->loadRelations($dto->relations)
            ->get($dto->paginated, $dto->per_page);
    }

    protected function prepareQuery(): self
    {
        $this->builder = Menu::query()
            ->whereNull('deleted_at');

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
