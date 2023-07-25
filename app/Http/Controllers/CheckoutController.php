<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Shipping;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

use App\Mail\OrderReceivedMail;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    //
    public function index()
    {

        $shippings = Shipping::all();
        $payments = Payment::all();
        $cart = Cart::where('user_id', Auth::id())->get();
        return View::make('checkout.index', compact('cart', 'shippings', 'payments'));
    }

    public function checkOut(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = Auth::user()->id;
            $userCart = Cart::where('user_id', $user_id)->get();
            $newOrder = new Order;

            $newOrder->user_id = $user_id;
            $newOrder->shipping_id = $request->shipping_id;
            $newOrder->payment_id = $request->payment_id;
            $newOrder->address = $request->address;
            $newOrder->card_num = $request->card_num;
            $newOrder->save();

            $order_id = Order::max('id');

            foreach ($userCart as $cart) {
                DB::table('orderlines')->insert([
                    "order_id" => $order_id,
                    "product_id" => $cart->product_id,
                    "quantity" => $cart->quantity,
                ]);
                $product = Product::find($cart->product_id);
                $product->quantity = $product->quantity - $cart->quantity;
                $product->save();
            }
            Cart::where('user_id', $user_id)->delete();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
        DB::commit();
        // return redirect()->route('cartindex')->with('message', 'ORDER PLACED');
        return redirect()->route('cartindex')->with('message', 'Order placed successfully!');
    }


    public function orderView()
    {
        $user_id = Auth::id();
        $orders = DB::table('orderlines')
            ->join('products', 'orderlines.product_id', '=', 'products.id')
            ->join('orders', 'orderlines.order_id', '=', 'orders.id')
            ->where('orders.user_id', $user_id)
            ->select('orderlines.order_id', 'orderlines.product_id', 'orderlines.quantity', 'products.name', 'products.price', 'orders.status')
            ->get();

        $overallTotal = 0;
        foreach ($orders as $order) {
            $subtotal = $order->price * $order->quantity;
            $overallTotal += $subtotal;
        }

        return view('vieworders.index', compact('orders', 'overallTotal'));
    }

    public function cancelOrder($orderId)
    {
        $orders = Order::where('id', $orderId)->get();
        if ($orders->isEmpty()) {
            return redirect()->back()->with('error', 'No orders found with the specified order ID.');
        }

        // Cancel each order
        foreach ($orders as $order) {
            if ($order->status !== 'cancelled') {
                $order->status = 'cancelled';
                $order->save();
            }
        }
        return redirect()->back()->with('message', 'Orders cancelled successfully.');
    }

    public function orderHistory()
    {
        $user = Auth::user();
        $receivedOrders = Order::where('user_id', $user->id)
            ->where('status', 'received')
            ->join('orderlines', 'orders.id', '=', 'orderlines.order_id')
            ->join('products', 'orderlines.product_id', '=', 'products.id')
            ->select('orders.id', 'products.name', 'products.price', 'orderlines.quantity')
            ->get();

        $cancelledOrders = Order::where('user_id', $user->id)
            ->where('status', 'cancelled')
            ->join('orderlines', 'orders.id', '=', 'orderlines.order_id')
            ->join('products', 'orderlines.product_id', '=', 'products.id')
            ->select('orders.id', 'products.name', 'products.price', 'orderlines.quantity')
            ->get();

        return view('viewhistory.index', compact('receivedOrders', 'cancelledOrders'));
    }
    //     public function orderHistory()
    // {
    //     $user = auth()->user();
    //     $orders = Order::where('user_id', $user->id)
    //         ->whereIn('status', ['received', 'cancelled'])
    //         ->with('orderlines.product')
    //         ->get();

    //     return view('order.history', compact('orders'));
    // }


    public function adminView()
    {
        // Retrieve all orders with pending status
        $orders = DB::table('orderlines')
            ->join('products', 'orderlines.product_id', '=', 'products.id')
            ->join('orders', 'orderlines.order_id', '=', 'orders.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.status', '=', 'pending')
            ->select(
                'orderlines.order_id',
                'orderlines.product_id',
                'orderlines.quantity',
                'products.name',
                'products.price',
                'orders.status',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->get();

        $overallTotal = 0;
        foreach ($orders as $order) {
            $subtotal = $order->price * $order->quantity;
            $overallTotal += $subtotal;
        }

        return view('vieworders.adminView', compact('orders', 'overallTotal'));
    }



    public function confirmOrder($orderId)
    {
        $orders = Order::find($orderId);

        if ($orders && $orders->status === 'pending') {
            $orders->status = 'intransit';
            $orders->save();

            // Send email notification to user/customer
            // You can implement the email sending logic here

            return redirect()->back()->with('message', 'Order confirmed successfully.');
        }

        return redirect()->back()->with('error', 'Failed to confirm order.');
    }

    //     public function orderReceived($orderId)
    // {
    //     // Update the order status to "Received"
    //     $order = Order::find($orderId);
    //     $order->status = 'Received';
    //     $order->save();

    //     // Show the success message
    //     session()->flash('message', 'Order Successfully Delivered');

    //     // Redirect back to the order page or any other page as needed
    //     return redirect()->back();
    // }

    public function orderReceived($orderId)
    {
        // Update the order status to "Received"
        $order = Order::find($orderId);

        if ($order && $order->status === 'intransit') {
            $order->status = 'Received';
            // $order->save();

            // Send email notification to user/customer
            try {
                // Mail::to($order->user->email)->send(new OrderReceivedMail());
                $mail = new OrderReceivedMail($order);
                $mailmessage = $mail->build();
                $mailmessage->from($order->user->email, $order->user->name);
                Mail::to('johnradilh.mancao@tup.edu.ph')->send($mailmessage);
            } catch (\Exception $e) {
                dd($e);
            }

            // Show the success message
            session()->flash('message', 'Order Successfully Delivered');

            // Redirect back to the order page or any other page as needed
            return redirect()->back();
        }

        return redirect()->back()->with('error', 'Failed to mark order as received.');
    }


    public function viewTransactions()
    {

        $transactions = DB::table('orderlines')
            ->join('orders', 'orderlines.order_id', '=', 'orders.id')
            ->join('products', 'orderlines.product_id', '=', 'products.id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->whereIn('orders.status', ['received'])
            ->select('orders.id as order_id', 'users.name as username', 'products.name', 'orderlines.quantity', 'products.price', 'orders.status')
            ->get();

        // dd($transactions);

        return view('transactions.index', compact('transactions'));
    }


    public function searchTransaction(Request $request)
    {
        $search = $request->input('search');

        $transactions = DB::table('orderlines')
            ->join('orders', 'orders.id', '=', 'orderlines.order_id')
            ->join('products', 'products.id', '=', 'orderlines.product_id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->whereIn('orders.status', ['received', 'cancelled'])
            ->where('order_id', 'like', '%' . $search . '%')
            ->orWhere('users.name', 'like', '%' . $search . '%')
            ->select('orders.id as order_id', 'users.name as username', 'products.name', 'orderlines.quantity', 'products.price', 'orders.status')
            ->get();

        // $transactions = DB::table('orderlines')
        //     ->join('orders', 'orderlines.order_id', '=', 'orders.id')
        //     ->join('products', 'orderlines.product_id', '=', 'products.id')
        //     ->join('users', 'users.id', '=', 'orders.user_id')
        //     ->whereIn('orders.status', ['received', 'cancelled'])
        //     ->where(function ($query) use ($search) {
        //         $query->where('users.username', 'like', '%' . $search . '%')
        //             ->orWhere('orders.id', 'like', '%' . $search . '%');
        //     })
        //     ->select('orders.id as order_id', 'users.name as username', 'products.name', 'orderlines.quantity', 'products.price', 'orders.status')
        //     ->get();

        return view('transactions.index', compact('transactions'));
    }
}
