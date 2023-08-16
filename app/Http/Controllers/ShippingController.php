<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\DataTables\ShippingDataTable;
use App\Http\Requests\ShippingRequest;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Storage;

class ShippingController extends Controller
{
    //
    // public function index()
    // {

    //     $shipment = Shipping::get();
    //     return view('shipping.index', compact('shipment'));
    // }

    // public function index(ShippingDataTable $dataTable)
    // {
    //     return $dataTable->render('shipping.index');
    // }
    public function index()
    {
        $shippings = Shipping::with(['media'])->get();
        return response()->json($shippings);
    }

    public function create()
    {
        return view('shipping.create');
    }

    // public function store(ShippingRequest $request)
    // {
    //     $validatedData = $request->validated();

    //     $method = new Shipping;
    //     $method->type = $validatedData['type'];


    //     if ($request->hasFile('delivery_image')) {
    //         $file = $request->file('delivery_image');

    //         $ext = $file->getClientOriginalExtension();
    //         $filename = time() . '.' . $ext;

    //         $file->move('storage/uploads/brands', $filename);

    //         $method->delivery_image = $filename;

    //         $method->save();

    //         return redirect('shipping/index')->with('message', 'Shipping method Added Successfully!');
    //     }
    // }

    // public function edit($id){
    //     $ship = Shipping::where('id', '=', $id)->first();
    //     return view('shipping/edit', compact('ship'));
    // }
    public function edit($id)
    {

        $shippings = Shipping::find($id);
        // dd($id);
        // return view('brand/edit', compact('brands'));
        return response()->json($shippings);
    }

    // public function update(Request $request, $id)
    // {

    //     $ship = Shipping::FindOrFail($id);

    //     $ship->type = $request->type;
      

    //     if ($request->hasFile('delivery_image')) {

    //         $path = 'storage/uploads/brands' . $ship->image;
    //         if (File::exists($path)) {
    //             File::delete($path);
    //         }
    //         $file = $request->file('delivery_image');

    //         $ext = $file->getClientOriginalExtension();
    //         $filename = time() . '.' . $ext;

    //         $file->move('storage/uploads/brands', $filename);

    //         $ship->delivery_image = $filename;
    //     }
    //     $ship->save();

    //     return redirect()->route('viewshippings')->with('message', 'Shipping Method Updated Successfully!');
    // }
    public function update(Request $request, $id)
    {
        $shippings = Shipping::FindOrFail($id);

        $shippings->type = $request->type;

        if ($request->hasFile('delivery_image')) {
            DB::table('media')->where('model_type', 'App\Models\Shipping')->where('model_id', $id)->delete();
            foreach ($request->file('delivery_image') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = Storage::putFileAs('public/images', $file, $fileName);
                $shippings->addMedia(storage_path("app/public/images/" . $fileName))->toMediaCollection("images");
            }
        }
        $shippings->delivery_image = "Default Edited";

        // if ($request->hasFile('image')) {

        //     $path = 'storage/uploads/brands' . $brands->image;
        //     if (File::exists($path)) {
        //         File::delete($path);
        //     }
        //     $file = $request->file('image');

        //     $ext = $file->getClientOriginalExtension();
        //     $filename = time() . '.' . $ext;

        //     $file->move('storage/uploads/brands', $filename);

        //     $brands->image = $filename;
        // }
        $shippings->save();

        // return redirect()->route('viewbrands')->with('message', 'Category Updated Successfully!');
        return response()->json($shippings);
    }
    // public function destroy($id)
    // {

    //     Shipping::where('id', '=', $id)->delete();

    //     return redirect()->route('viewshippings')->with('message', 'Shipping Method Deleted Successfully!');
    // }

    public function destroy($id)
    {

        Shipping::destroy($id);
        // return redirect()->route('viewbrands')->with('message', 'Category Deleted Successfully!');
        return response()->json([]);
    }

    public function store(Request $request)
    {


        try {
            $shippings = new Shipping();
            $shippings->type = $request->type;
            $shippings->delivery_image = "Default";
 
            Debugbar::info($request->file('delivery_image'));

            if ($request->hasFile('delivery_image')) {
                foreach ($request->file('delivery_image') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $path = Storage::putFileAs('public/images', $file, $fileName);
                    $shippings->addMedia(storage_path("app/public/images/" . $fileName))->toMediaCollection("images");
                }
            }
        } catch (\Exception $e) {
            Debugbar::info($e);
        }

        $shippings->save();

        return response()->json($shippings);
    }
}


