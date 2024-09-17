<?php

namespace App\DataTables\Scopes\ProductVariant;

use Yajra\DataTables\Contracts\DataTableScope;

class FilterByStock implements DataTableScope
{


    private $stockid;

    public function __construct(string $stockid)
    {
        $this->stockid = $stockid;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
        return $query->where('variant_stockid', $this->stockid);
    }
}
