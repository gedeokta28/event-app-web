<?php

namespace App\DataTables;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\UserEvent;
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
            ->addColumn('check_in', function ($event) {
                $today = now()->format('Y-m-d');
                $attendance = Attendance::where('event_reg_id', $event->reg_id)
                    ->whereDate('attendance_date_time', $today)
                    ->first();

                if ($attendance) {
                    return '<span class="badge bg-success">Checked In</span>'; // Shortened message
                } else if (!$event->reg_success) {
                    return '<button class="btn btn-secondary" disabled>Registration Incomplete</button>'; // Disabled button
                } else {
                    return '<button class="btn btn-primary check-in-btn" data-reg-id="' . $event->reg_id . '">Check In</button>';
                }
            })

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
            ->rawColumns(['reg_success', 'check_in', 'action']); // Make sure to allow raw HTML
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Event $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EventRegistration $model): QueryBuilder
    {
        if (auth()->user()->user_id == "1") {
            return $model->newQuery()
                ->select();
        } else {
            $userId = auth()->user()->user_id;
            $userEventFind = UserEvent::where('user_id', $userId)->pluck('event_id')->toArray();
            $userEvent = Event::find($userEventFind[0]);
            return $model->newQuery()
                ->where('event_id', $userEvent->event_id);
        }
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
