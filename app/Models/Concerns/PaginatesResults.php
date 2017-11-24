<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait PaginatesResults
{
    /**
     * Method that paginates results based on "page" query string.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  int  $perpage
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopePaginated(Builder $builder, $perPage)
    {
        $page = request()->query('page') ?? 1;

        return $builder->skip($perPage * ($page - 1))->take($perPage)->get();
    }
}
