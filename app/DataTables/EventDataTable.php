<?php

namespace App\DataTables;

use App\Models\Event;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class EventDataTable extends DataTable
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
            ->addColumn('action', function ($event) {
                return view('events.datatable_action', compact('event'));
            })
            ->addColumn('event_dates', function ($event) {
                // Format the dates
                $startDate = Carbon::parse($event->event_start_date)->format('d M Y');
                $endDate = Carbon::parse($event->event_end_date)->format('d M Y');

                // For different start and end dates
                return $startDate . ' - ' . $endDate;
            })
            ->addColumn('event_time', function ($event) {

                $eventTime = $event->event_time; // Assumed to be in the format "08:00 - 17:00"


                // For different start and end dates
                return $eventTime;
            })
            ->addColumn('event_active', function ($event) {
                return $event->event_active ? 'Active' : 'Inactive';
            })
            ->addIndexColumn()
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Event $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Event $model): QueryBuilder
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
        return EventDataTableHtml::make();
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Event_' . date('YmdHis');
    }
}
