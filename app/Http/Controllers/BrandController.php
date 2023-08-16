<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\DataTables\BrandDataTable;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;
use App\Imports\BrandImportClass;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with(['media'])->get();
        return response()->json($brands);
    }
    public function importBrands(Request $request)
    {
        $file = $request->file('excel_file');
        Excel::import(new BrandImportClass, $file);

        return redirect()->back()->with('success', 'Brands imported successfully.');
    }

    // public function index(BrandDataTable $dataTable)
    // {
    //     return $dataTable->render('brand.index');
    // }

    public function create()
    {
        return view('brand.create');
    }


    // public function store(BrandRequest $request)
    // {
    //     $validatedData = $request->validated();

    //     $brand = new Brand;
    //     $brand->name = $validatedData['name'];
    //     $brand->slug = Str::slug($validatedData['slug']);
    //     $brand->description = $validatedData['description'];

    //     if($request->hasFile('image')){
    //         $file = $request->file('image');

    //         $ext =$file->getClientOriginalExtension();
    //         $filename = time().'.'.$ext;

    //         $file->move('storage/uploads/brands',$filename);

    //         $brand->image = $filename;

    //         $brand->save();

    //         return redirect('brand/index')->with('message','Brand Added Successfully!');
    //     }
    //     $image = array();
    //     if ($files = $request->file('image')) {
    //         foreach ($files as $file) {
    //             $name = md5(rand(1000, 10000));
    //             $ext = strtolower($file->getClientOriginalExtension());
    //             $image_full_name = $name . '' . $ext;
    //             $upload_path = 'storage/uploads/';
    //             $image_url = $upload_path . $image_full_name;
    //             $file->move($upload_path, $image_full_name);
    //             $image[] = $image_url;
    //         }

    //         Brand::insert([

    //             'image' => implode('|', $image),

    //         ]);
    //     }
    // }

    public function edit($id)
    {

        $brands = Brand::find($id);
        // dd($id);
        // return view('brand/edit', compact('brands'));
        return response()->json($brands);
    }

    public function update(Request $request, $id)
    {
        $brands = Brand::FindOrFail($id);

        $brands->name = $request->name;
        $brands->slug = $request->slug;
        $brands->description = $request->description;

        if ($request->hasFile('image')) {
            DB::table('media')->where('model_type', 'App\Models\Brand')->where('model_id', $id)->delete();
            foreach ($request->file('image') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = Storage::putFileAs('public/images', $file, $fileName);
                $brands->addMedia(storage_path("app/public/images/" . $fileName))->toMediaCollection("images");
            }
        }
        $brands->image = "Default Edited";

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
        $brands->save();

        // return redirect()->route('viewbrands')->with('message', 'Category Updated Successfully!');
        return response()->json($brands);
    }
    public function destroy($id)
    {

        Brand::destroy($id);
        // return redirect()->route('viewbrands')->with('message', 'Category Deleted Successfully!');
        return response()->json([]);
    }

    public function store(Request $request)
    {


        try {
            $brands = new Brand;
            $brands->name = $request->name;
            $brands->slug = $request->slug;
            $brands->image = "Default";
            $brands->description = $request->description;
            Debugbar::info($request->file('image'));

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $path = Storage::putFileAs('public/images', $file, $fileName);
                    $brands->addMedia(storage_path("app/public/images/" . $fileName))->toMediaCollection("images");
                }
            }
        } catch (\Exception $e) {
            Debugbar::info($e);
        }

        $brands->save();

        return response()->json($brands);
    }
}
