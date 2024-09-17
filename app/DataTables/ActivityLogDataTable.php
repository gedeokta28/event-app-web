<?php

namespace App\DataTables;

use Spatie\Activitylog\Models\Activity as ActivityLog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class ActivityLogDataTable extends DataTable
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
            ->setRowId('id')
            ->addIndexColumn()
            ->editColumn('actor', function ($activity) {
                return $activity->causer?->name ?? '-';
            })
            ->editColumn('created_at', function ($activity) {
                return $activity->created_at->format('d-m-Y H:i:s');
            })
            ->editColumn('data', function ($activity) {
                return substr($activity->subject_type, 11) . ' - ' . $activity->subject_id;
            })
            ->filterColumn('actor', function ($query, $keyword) {
                return $query->whereHas('causer', function ($q) use (&$keyword) {
                    return $q->where('name', 'like', "%$keyword%");
                });
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Spatie\Activitylog\Models\Activity $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ActivityLog $model): QueryBuilder
    {
        return $model->newQuery()
            ->with(['causer'])
            ->select('activity_log.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return ActivityLogDataTableHtml::make();
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'ActivityLog_' . date('YmdHis');
    }
}
