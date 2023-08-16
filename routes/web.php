<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('productcollection');
});

Auth::routes();
//Route users
Route::middleware(['auth', 'user-role:user'])->group(function () {

    Route::get('user/home', [App\Http\Controllers\HomeController::class, 'userHome'])->name('home');
});
//Route supplier
Route::middleware(['auth', 'user-role:supplier'])->group(function () {

    Route::get('/supplier/home', [App\Http\Controllers\HomeController::class, 'supplierHome'])->name('supdash');
});
//Route admin
Route::middleware(['auth', 'user-role:admin'])->group(function () {

    Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home');
});
Route::middleware('auth')->group(function(){
    Route::post('collection/products/{id}',[App\Http\Controllers\CartController::class,'addcart'])->name('addtocart');
    Route::get('cart/index', [App\Http\Controllers\CartController::class, 'index'])->name('cartindex');    
    Route::get('/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('deletecartitem');   
    Route::patch('/cart/{id}',[App\Http\Controllers\CartController::class, 'updatecartItem'])->name('updatecartitem'); 
    Route::get('/checkout/index',[App\Http\Controllers\CheckoutController::class, 'index'])->name('gocheckout');
    Route::post('/place/order',[App\Http\Controllers\CheckoutController::class, 'checkOut'])->name('checkOut');
    Route::get('vieworders/index',[App\Http\Controllers\CheckoutController::class,'orderView'])->name('Orders');
    Route::get('viewhistory/index', [App\Http\Controllers\CheckoutController::class, 'orderHistory'])->name('orderHistory');
    Route::post('/cancel-order/{orderId}', [App\Http\Controllers\CheckoutController::class, 'cancelOrder'])->name('cancelOrders');
    Route::get('vieworders/adminView', [App\Http\Controllers\CheckoutController::class, 'adminView'])->name('viewAllorders');
    Route::post('/confirm-order/{orderId}', [App\Http\Controllers\CheckoutController::class, 'confirmOrder'])->name('confirmOrders');
    Route::post('/order-received/{orderId}', [App\Http\Controllers\CheckoutController::class, 'orderReceived'])->name('orderReceived');
    Route::get('transactions/index', [App\Http\Controllers\CheckoutController::class, 'viewTransactions'])->name('viewTransactions');
    Route::get('searchtrans/result',[App\Http\Controllers\CheckoutController::class,'searchTransaction'])->name('searchTransactions');

});
// Route::middleware('auth')->get('/orders', [App\Http\Controllers\CheckoutController::class,'viewOrders'])->name('orders');

Route::view('/brand/modaljs','brand.modal.md-index')->name('modal.brand');
Route::view('/shipping/modaljs','shipping.modal.md-index')->name('modal.shipping');
Route::view('/payment/modaljs','payment.modal.md-index')->name('modal.payment');

//Brand Crud
Route::prefix('brand')->group(function () {
    Route::get('/index', [App\Http\Controllers\BrandController::class, 'index'])->name('viewbrands');
    Route::get('index/create', [App\Http\Controllers\BrandController::class, 'create'])->name('createbrands');
    Route::post('brand', [App\Http\Controllers\BrandController::class, 'store'])->name('addbrands');
    Route::get('/{id}/edit', [App\Http\Controllers\BrandController::class, 'edit'])->name('editbrands');
    Route::post('/{id}', [App\Http\Controllers\BrandController::class, 'update'])->name('updatebrands');
    Route::delete('/{id}', [App\Http\Controllers\BrandController::class, 'destroy'])->name('deletebrands');
    Route::post('import/index', [App\Http\Controllers\BrandController::class,'importBrands'])->name('import.brands');

});
//Home collection Categories
Route::prefix('Category')->group(function(){
    Route::get('/brandcategory', [App\Http\Controllers\CollectionController::class, 'index'])->name('brandcollection');
    Route::get('/products', [App\Http\Controllers\CollectionController::class, 'productcollections'])->name('productcollection');
    
}); 
//Product Crud
Route::prefix('product')->group(function(){
    Route::get('/index',[App\Http\Controllers\ProductController::class,'index'])->name('viewproducts');
    Route::get('index/create',[App\Http\Controllers\ProductController::class,'create'])->name('createproducts');
    Route::post('index/product',[App\Http\Controllers\ProductController::class,'store'])->name('addproducts');
    Route::get('/{id}/edit',[App\Http\Controllers\ProductController::class,'edit'])->name('editproducts');
    Route::post('/{id}',[App\Http\Controllers\ProductController::class,'update'])->name('updateproducts');
    Route::get('{id}',[App\Http\Controllers\ProductController::class,'destroy'])->name('deleteproducts');
    Route::post('import/index',[App\Http\Controllers\ProductController::class,'importProducts'])->name('import.products');

  

});
//search products
Route::get('search/result',[App\Http\Controllers\ProductController::class,'search'])->name('productSearch');

Route::prefix('shipping')->group(function(){
    Route::get('/index',[App\Http\Controllers\ShippingController::class,'index'])->name('viewshippings');
    Route::get('index/create',[App\Http\Controllers\ShippingController::class,'create'])->name('createshipping');
    Route::post('shipping',[App\Http\Controllers\ShippingController::class,'store'])->name('addShipping');
    Route::get('/{id}/edit',[App\Http\Controllers\ShippingController::class,'edit'])->name('editShipping');
    Route::post('/{id}',[App\Http\Controllers\ShippingController::class,'update'])->name('updateShipping');
    Route::delete('{id}',[App\Http\Controllers\ShippingController::class,'destroy'])->name('deleteShipping');
});

Route::prefix('payment')->group(function(){
    Route::get('/index',[App\Http\Controllers\PaymentController::class,'index'])->name('viewpayments');
    Route::get('index/create',[App\Http\Controllers\PaymentController::class,'create'])->name('createpayment');
    Route::post('payment',[App\Http\Controllers\PaymentController::class,'store'])->name('addPayment');
    Route::get('/{id}/edit',[App\Http\Controllers\PaymentController::class,'edit'])->name('editPayment');
    Route::post('/{id}',[App\Http\Controllers\PaymentController::class,'update'])->name('updatePayment');
    Route::delete('{id}',[App\Http\Controllers\PaymentController::class,'destroy'])->name('deletePayment');
});

