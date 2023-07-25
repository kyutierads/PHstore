<?php

namespace App\DataTables;

use App\Models\Product;
use App\Models\ProductDataTables;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->query($query)
            ->addColumn('image', function ($product) {
                return '<img src="' . asset('storage/uploads/brands/' . $product->image) . '" height="50" alt="' . $product->name . '">';
            })
            ->addColumn('brand_name', function($product){
                return $product->bname;
            })
            ->addColumn('action', function ($product) {
                return '<a href="'.route('editbrands',$product->id).'" class="btn btn-success">Edit</a>
                <form action= "'.route('deletebrands', $product->id).'" method="POST">
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
     * @param \App\Models\ProductDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
    {
        $products = DB::table('brands')->join('products','brands.id','=','products.brand_id')
        ->select('brands.name as bname','brands.slug','brands.description','brands.image','products.id',
        'products.name','products.description','products.image','products.price','products.quantity','products.brand_id');

        return $products;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('productdatatable-table')
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
           
            Column::make('image'),
            Column::make('name'),
            Column::make('slug'),
            Column::make('description'),
            Column::make('price'),
            Column::make('quantity'),
            Column::make('brand_name'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Product_' . date('YmdHis');
    }
}
