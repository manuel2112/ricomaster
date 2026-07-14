<?php

namespace App\Actions\TypeMenu;

use App\Models\TypeMenu;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class ListTypeMenu
{
    use AsAction;

    private Builder $builder;

    public function handle(): Collection|LengthAwarePaginator
    {
        return $this->prepareQuery()
            ->loadRelations([])
            ->get();
    }

    protected function prepareQuery(): self
    {
        $this->builder = TypeMenu::query();

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
