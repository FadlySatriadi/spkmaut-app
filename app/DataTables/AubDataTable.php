<?php

namespace App\DataTables;

use App\Models\AubModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AubDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($aub) {
                $btn = '<a href="'.url('/aub/'.$aub->idaub).'" class="btn btn-sm btn-info">Detail</a> ';
                $btn .= '<a href="'.url('/aub/'.$aub->idaub.'/edit').'" class="btn btn-sm btn-warning">Edit</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->setRowId('idaub'); // Pastikan sesuai primary key
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AubModel $model): QueryBuilder
    {
        return $model->newQuery()->select('idaub', 'kodeaub', 'namaaub');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('aub_table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1, 'asc')
                    // ->dom('Bfrtip')
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ])
                    ->parameters([
                        'responsive' => true,
                        'autoWidth' => false,
                        'language' => [
                            'url' => asset('vendor/datatables/lang/id.json') // Jika butuh bahasa Indonesia
                        ]
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('idaub')->title('ID AUB'),
            Column::make('kodeaub')->title('Kode AUB'),
            Column::make('namaaub')->title('Nama AUB'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(150)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AUB_' . date('YmdHis');
    }
}