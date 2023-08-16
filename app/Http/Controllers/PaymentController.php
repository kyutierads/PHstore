<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Shipping;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\PaymentDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\PaymentRequest;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    //   public function index()
    // {

    //     $payment = Payment::get();
    //     return view('payment.index', compact('payment'));
    // }

    
    // public function index(PaymentDataTable $dataTable)
    // {
    //     return $dataTable->render('payment.index');
    // }
    public function index()
    {
        $payments = Payment::with(['media'])->get();
        return response()->json($payments);
    }


    public function create()
    {
        return view('payment.create');
    }

    // public function store(PaymentRequest $request)
    // {
    //     $validatedData = $request->validated();

    //     $method = new Payment();
    //     $method->type = $validatedData['type'];


    //     if ($request->hasFile('payment_image')) {
    //         $file = $request->file('payment_image');

    //         $ext = $file->getClientOriginalExtension();
    //         $filename = time() . '.' . $ext;

    //         $file->move('storage/uploads/brands', $filename);

    //         $method->payment_image = $filename;

    //         $method->save();

    //         return redirect('payment/index')->with('message', 'Payment method Added Successfully!');
    //     }
    // }

    public function store(Request $request)
    {


        try {
            $payments = new Payment();
            $payments->type = $request->type;
            $payments->payment_image = "Default";
 
            Debugbar::info($request->file('payment_image'));

            if ($request->hasFile('payment_image')) {
                foreach ($request->file('payment_image') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $path = Storage::putFileAs('public/images', $file, $fileName);
                    $payments->addMedia(storage_path("app/public/images/" . $fileName))->toMediaCollection("images");
                }
            }
        } catch (\Exception $e) {
            Debugbar::info($e);
        }

        $payments->save();

        return response()->json($payments);
    }

    // public function edit($id){
    //     $payment = Payment::where('id', '=', $id)->first();
    //     return view('payment/edit', compact('payment'));
    // }
    public function edit($id)
    {

        $payments = Payment::find($id);
        // dd($id);
        // return view('brand/edit', compact('brands'));
        return response()->json($payments);
    }

    // public function update(Request $request, $id)
    // {

    //     $payment = Payment::FindOrFail($id);

    //     $payment->type = $request->type;
      

    //     if ($request->hasFile('payment_image')) {

    //         $path = 'storage/uploads/brands' . $payment->payment_image;
    //         if (File::exists($path)) {
    //             File::delete($path);
    //         }
    //         $file = $request->file('payment_image');

    //         $ext = $file->getClientOriginalExtension();
    //         $filename = time() . '.' . $ext;

    //         $file->move('storage/uploads/brands', $filename);

    //         $payment->payment_image = $filename;
    //     }
    //     $payment->save();

    //     return redirect()->route('viewpayments')->with('message', 'Payment Method Updated Successfully!');
    // }
    public function update(Request $request, $id)
    {
        $payment = Payment::FindOrFail($id);

        $payment->type = $request->type;

        if ($request->hasFile('payment_image')) {
            DB::table('media')->where('model_type', 'App\Models\Payment')->where('model_id', $id)->delete();
            foreach ($request->file('payment_image') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = Storage::putFileAs('public/images', $file, $fileName);
                $payment->addMedia(storage_path("app/public/images/" . $fileName))->toMediaCollection("images");
            }
        }
        $payment->payment_image = "Default Edited";

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
        $payment->save();

        return response()->json($payment);
    }
    public function destroy($id)
    {

        Payment::destroy($id);
        // return redirect()->route('viewbrands')->with('message', 'Category Deleted Successfully!');
        return response()->json([]);
    }
}
