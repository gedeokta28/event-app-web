<?php

namespace App\DataTables;

use App\Models\Attendance;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Button;

class AttendanceDataTable extends DataTable
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
            ->addIndexColumn()
            ->editColumn('attendance_date', function ($row) {
                // Format the date to Indonesian locale (e.g., 9 Oktober 2024)
                return Carbon::parse($row->attendance_date)->translatedFormat('j F Y');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Attendance $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Attendance $model): QueryBuilder
    {
        $event = Event::where('slug', $this->event_id)->firstOrFail();

        // Group by the date component of attendance_date_time
        return $model->newQuery()
            ->selectRaw('DATE(attendance_date_time) as attendance_date, COUNT(*) as total_attendances')
            ->where('event_id', $event->event_id)
            ->groupBy('attendance_date') // Group by the date
            ->orderBy('attendance_date', 'desc'); // Order by date in descending order
    }


    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->lengthMenu([-1], ['All'])
            ->buttons([])
            ->footerCallback(
                'function (row, data, start, end, display) {
                var api = this.api();
                var totalAttendance = api.column(1).data().reduce(function (a, b) {
                    return a + b;
                }, 0);
                var footerHtml = "Total Attendance: " + totalAttendance;
                // Update footer
                $(api.column(1).footer()).html(footerHtml);
                
            }'
            );
    }


    /**
     * Get columns for dataTable.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            ['data' => 'attendance_date', 'title' => 'Attendance Date'], // Ensure you define titles for clarity
            ['data' => 'total_attendances', 'title' => 'Total Attendances'],
        ];
    }
    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Attendance_' . date('YmdHis');
    }
}
