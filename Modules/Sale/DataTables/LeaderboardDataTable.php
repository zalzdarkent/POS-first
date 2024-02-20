<?php

namespace Modules\Sale\DataTables;

use Modules\Sale\Entities\SaleDetails;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LeaderboardDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('total_quantity_sold', function ($data) {
                return $data->total_quantity_sold;
            })
            ->addColumn('total_revenue', function ($data) {
                return format_currency($data->total_revenue / 100);
            });
    }

    public function query(SaleDetails $model)
    {
        return $model->newQuery()
            ->select('product_id', 'product_name')
            ->selectRaw('SUM(quantity) as total_quantity_sold')
            ->selectRaw('SUM(unit_price * quantity) as total_revenue') // Hitung total pendapatan dari penjualan
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [date('Y-m')])
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_quantity_sold');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('leaderboard-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                'tr' .
                                <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(1)
            ->buttons(
                Button::make('excel')
                    ->text('<i class="bi bi-file-earmark-excel-fill"></i> Excel'),
                Button::make('print')
                    ->text('<i class="bi bi-printer-fill"></i> Print'),
                Button::make('reset')
                    ->text('<i class="bi bi-x-circle"></i> Reset'),
                Button::make('reload')
                    ->text('<i class="bi bi-arrow-repeat"></i> Reload')
            );
    }

    protected function getColumns()
    {
        return [
            Column::make('product_name')
                ->title('Nama Produk')
                ->className('text-center align-middle'),

            Column::make('total_quantity_sold')
                ->title('Total Terjual')
                ->className('text-center align-middle'),

            Column::make('total_revenue')
                ->title('Total Pendapatan')
                ->className('text-center align-middle'),
        ];
    }

    protected function filename(): string
    {
        return 'Leaderboard_' . date('YmdHis');
    }
}