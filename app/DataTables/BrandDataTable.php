<?php

namespace App\DataTables;

use App\Models\Brand;
use App\Models\BrandDataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BrandDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    // public function dataTable($query)
    // {
    //     return datatables()
    //         ->eloquent($query)
    //         ->addColumn('action', 'branddatatable.action');
    // }
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('image', function ($brand) {
                return '<img src="' . asset('storage/uploads/brands/' . $brand->image) . '" height="50" alt="' . $brand->name . '">';
            })
            ->rawColumns(['image'])
            ->addColumn('action', function ($brand) {
                return '<a href="'.route('editbrands',$brand->id).'" class="btn btn-success">Edit</a>
                <form action= "'.route('deletebrands', $brand->id).'" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <button type="hidden" class="delete btn btn-danger btn-sm">Delete</button>
                </form>';
            })
            ->rawColumns(['action', 'image']);
    }
    
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\BrandDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Brand $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('branddatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('image')
            ->exportable(false)
            ->printable(false),
            Column::make('name'),
            Column::make('slug'),
            Column::make('description'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }


    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Brand_' . date('YmdHis');
    }

    
}
