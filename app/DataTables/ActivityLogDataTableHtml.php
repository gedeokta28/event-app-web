<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\DataTableHtml;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class ActivityLogDataTableHtml extends DataTableHtml
{
    /**
     * Build the html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     * @throws \Exception
     */
    public function handle(): Builder
    {
        return $this->setTableId('activitylog-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('frtip')
            ->orderBy(7)
            // ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            // Column::computed('action')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width(60)
            //     ->addClass('text-center'),
            Column::make('id')->visible(false)->printable(false)->exportable(false),
            Column::computed('DT_RowIndex')->title('#'),
            // Column::make('log_name'),
            Column::make('description'),
            Column::make('subject_type')->visible(false)->printable(false)->exportable(false),
            // Column::make('event'),
            Column::make('subject_id')->visible(false)->printable(false)->exportable(false),
            // Column::make('causer_type')->title('Actor'),
            Column::computed('data')->title('Data'),
            Column::computed('actor')->searchable(true)->title('Actor'),
            // Column::make('causer_id'),
            // Column::make('properties'),
            // Column::make('batch_uuid'),
            Column::make('created_at'),
            // Column::make('updated_at'),
        ];
    }
}
