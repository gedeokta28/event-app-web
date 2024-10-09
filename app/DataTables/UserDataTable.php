<?php

namespace App\DataTables;

use App\Models\Event;
use App\Models\User;
use App\Models\UserEvent;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class UserDataTable extends DataTable
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
            ->addColumn('action', function ($users) {
                return view('users.datatable_action', compact('users'));
            })
            ->addColumn('events', function ($users) {
                // Retrieve the events associated with the user
                $userEventFind = UserEvent::where('user_id', $users->user_id)->pluck('event_id')->toArray();
                $userEvent = Event::find($userEventFind[0]);
                // You can modify this to get event names instead, if needed
                return $userEvent->event_name; // Joining event IDs as a string, adjust if you have event names
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
    public function query(User $model): QueryBuilder
    {
        // Exclude user_id = 1
        return $model->newQuery()
            ->where('user_id', '!=', 1)->orderBy('user_id', 'desc'); // Add this line to filter out user_id = 1
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return UserDataTableHtml::make();
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
