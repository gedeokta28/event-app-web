<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\DataTableHtml;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class RegisDataTableHtml extends DataTableHtml
{
    /**
     * Build the html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     * @throws \Exception
     */
    public function handle(): Builder
    {
        return $this->setTableId('registration-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('frtip')
            ->orderBy(0)
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
            Column::make('event_id')->title('Event Id'),
            Column::make('pax_name')->title('Name'),
            Column::make('pax_phone')->title('Phone'),
            Column::make('pax_email')->title('Email'),
            Column::make('pax_company_name')->title('Company'),
            Column::make('reg_success')->title('Status Reg'),
        ];
    }
}
