<?php

namespace App\DataTables;

use App\Models\EventRegistration;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class RegisDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('reg_date_time', function ($event) {
                // Convert string to Carbon instance, then format
                return Carbon::parse($event->reg_date_time)->format('d F Y'); // Format as "25 September 2024"
            })
            ->addColumn('reg_success', function ($event) {
                return $event->reg_success
                    ? '<span style="color: green;">Success</span>'
                    : '<span style="color: red;">Failure</span>';
            })
            ->addIndexColumn()
            ->rawColumns(['reg_success']); // Make sure to allow raw HTML
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Event $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EventRegistration $model): QueryBuilder
    {
        return $model->newQuery()
            ->select();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return RegisDataTableHtml::make();
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Registration_' . date('YmdHis');
    }
}
