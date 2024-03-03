<?php

use App\Models\Cart;
use App\Models\Product;
use App\Events\TestEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardRevenueRecap;
use App\Http\Controllers\NotifcationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardCashierController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardCategoryController;
use App\Http\Controllers\DashboardTransactionAdminController;

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

Route::get('/login', [LoginController::class, 'index'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');

Route::post('/register', [RegisterController::class, 'store']);

Route::post('/logout', [LoginController::class, 'logout']);

/* Route::get('/test-react', function(){
    return view('welcome');
}); */

Route::middleware(['auth', /* 'admin' */ 'can:isAdmin'])->group(function () {
    Route::get('/revenue', [DashboardRevenueRecap::class, 'index'])->name('revenue');

    Route::get('/revenue/export-excel', [DashboardRevenueRecap::class, 'export_excel'])->name('revenue-export');

    Route::resource('product-manage', DashboardProductController::class);

    Route::resource('category-manage', DashboardCategoryController::class);

    Route::resource('user-manage', DashboardUserController::class);

    Route::resource('cashier-manage', DashboardCashierController::class);

    Route::get('/get-product',[ DashboardCashierController::class, 'getProduct']);
   
    Route::post('/store-product',[ DashboardTransactionAdminController::class, 'store']);

    Route::put('/transaction-status/{id}', [App\Http\Controllers\DashboardTransactionAdminController::class, 'update'])->name('transaction-update-status');

    Route::get('/transaction-admin', [App\Http\Controllers\DashboardTransactionAdminController::class, 'index'])->name('transaction-admin');
    
    Route::get('/transaction-details-admin/{id}', [App\Http\Controllers\DashboardTransactionAdminController::class, 'details'])->name('transaction-details-admin');

    Route::get('/transaction-details-product-admin/{id}', [App\Http\Controllers\DashboardTransactionAdminController::class, 'detailProducts'])->name('transaction-details-product-admin');

    Route::get('/transaction-admin-done', [App\Http\Controllers\DashboardTransactionAdminController::class, 'indexDone'])->name('transaction-admin-done');

    Route::get('/transaction-details-admin-done/{id}', [App\Http\Controllers\DashboardTransactionAdminController::class, 'detailsDone'])->name('transaction-details-admin-done');

    Route::get('/transaction-details-product-admin-done/{id}', [App\Http\Controllers\DashboardTransactionAdminController::class, 'detailProductsDone'])->name('transaction-details-product-admin-done');

    Route::get('/mark-as-read/{id}', [DashboardTransactionAdminController::class, 'marksAsReadProductEmpty'])->name('mark-as-read');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $productsNew = Product::latest()->first();
        $cartItems = Cart::where('users_id', Auth::user()->id)->count();

        return view('pages/dashboard', ['productsNew' => $productsNew, 'cartItems' => $cartItems]);
    });

    Route::get('/profile/{id}', [UserController::class, 'editUser'])->name('profile');

    Route::put('/profile-update/{id}', [UserController::class, 'update'])->name('profile-update');

    Route::resource('transaction', CheckoutController::class);

    Route::get('/product', [ProductController::class, 'index'])->name('product-all');

    Route::get('/detail/{id}', [DetailController::class, 'index'])->name('detail');

    Route::post('/detail/{id}', [App\Http\Controllers\DetailController::class, 'add'])->name('detail-add');

    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');

    Route::put('/cart/updateQty', [App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.updateqty');

    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'delete'])->name('cart-delete');

    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout');

    Route::get('/transaction', [App\Http\Controllers\TransactionController::class, 'index'])->name('transaction-user');

    Route::get('/transaction-details/{id}', [App\Http\Controllers\TransactionController::class, 'details'])->name('transaction-details');

    Route::get('/transaction-details-product/{id}', [App\Http\Controllers\TransactionController::class, 'detailProducts'])->name('transaction-details-product');

    Route::put('/transaction-proof/{id}', [App\Http\Controllers\TransactionController::class, 'update'])->name('transaction-proof');

    Route::get("/send-event", function(){
        broadcast(new  TestEvent());
    });

    Route::post("/send-notification/{id}", [NotificationController::class, 'userTransaction'])->name('send-notification');
});

/* Route::get('/token', function () {
        return csrf_token(); 
    }); */