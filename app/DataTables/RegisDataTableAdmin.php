<?php

namespace App\DataTables;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\UserEvent;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class RegisDataTableAdmin extends DataTable
{
    protected $event_id;

    /**
     * Set event ID to filter the query.
     *
     * @param int $event_id
     * @return $this
     */
    public function setEventId($event_id)
    {
        $this->event_id = $event_id;
        return $this;
    }
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
            ->addColumn('action', function ($registrations) {
                return view('registrations.datatable_action', compact('registrations'));
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
        $event = Event::where('slug', $this->event_id)->firstOrFail();

        return $model->newQuery()
            ->where('event_id', $event->event_id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return RegisDataTableHtmlAdmin::make();
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
