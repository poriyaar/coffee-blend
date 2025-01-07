<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Products\ProductsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/sevices', [App\Http\Controllers\HomeController::class, 'sevices'])->name('sevices');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'products'], function () {
    // products
    Route::get('/product-single/{product}', [ProductsController::class, 'singleProduct'])->name('product.single');
    Route::post('/product-single/{product}', [ProductsController::class, 'addCart'])->name('add.cart');
    Route::get('/cart', [ProductsController::class, 'cart'])->name('cart')->middleware('auth:web');
    Route::get('/cart-delete/{cart}', [ProductsController::class, 'deleteProductCart'])->name('delete.product.cart');

    // checkout
    Route::post('/prepare-checkout', [ProductsController::class, 'prepareCheckout'])->name('prepare.checkout');
    Route::get('/checkout', [ProductsController::class, 'checkout'])->name('checkout')->middleware('auth:web');
    Route::post('/checkout', [ProductsController::class, 'storeCheckout'])->name('proccess.checkout');


    // booking
    Route::post('/booking', [ProductsController::class, 'bookTables'])->name('booking.table')->middleware('auth:web');


    // menu
    Route::get('/menu', [ProductsController::class, 'menu'])->name('products.menu');
});

// users page
Route::get('users/orders', [UsersController::class, 'displayOrders'])->name('users.orders')->middleware('auth:web');
Route::get('users/bookings', [UsersController::class, 'bookings'])->name('users.bookings')->middleware('auth:web');



Route::get('admin/login', [AdminController::class, 'loginView'])->name('login.view')->middleware('check.for.auth');
Route::post('admin/login', [AdminController::class, 'checkLogin'])->name('check.login');
Route::post('admin/logout', [AdminController::class, 'checklogout'])->name('admin.logout');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    Route::get('/index', [AdminController::class, 'index'])->name('admin.dashboard');


    // admins section
    Route::get('/all-admins', [AdminController::class, 'DisplayAdmins'])->name('all.admins');
    Route::get('/create', [AdminController::class, 'create'])->name('create.admins');
    Route::post('/store', [AdminController::class, 'store'])->name('store.admins');


    // orders
    Route::get('/all-orders', [AdminController::class, 'DisplayOrders'])->name('all.orders');
    Route::get('/edit/orders/{order}', [AdminController::class, 'editOrder'])->name('edit.order');
    Route::post('/update/order/{order}', [AdminController::class, 'updateOrder'])->name('update.order');
    Route::get('/delte/order/{order}', [AdminController::class, 'deleteOrder'])->name('delete.order');




    // products
    Route::get('/all-products', [AdminController::class, 'DisplayProducts'])->name('all.products');
    Route::get('/create/product', [AdminController::class, 'createProducts'])->name('create.product');
    Route::post('/store/product', [AdminController::class, 'storeProducts'])->name('store.product');
    Route::get('/delete/product/{product}', [AdminController::class, 'deleteProduct'])->name('delete.product');


    // bookings
    Route::get('/all/bookings', [AdminController::class, 'DisplayBookings'])->name('all.bookings');
    Route::get('/delete/bookings/{booking}', [AdminController::class, 'deleteBookings'])->name('delete.booking');

});
