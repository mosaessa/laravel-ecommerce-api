<?php

use App\Http\Controllers\Buyer\BuyerCategoryController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerSellerController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Category\CategoryBuyerController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\CategoryProductController;
use App\Http\Controllers\Category\CategorySellerController;
use App\Http\Controllers\Category\CategoryTransactionController;
use App\Http\Controllers\Product\ProductBuyerController;
use App\Http\Controllers\Product\ProductBuyerTransactionController;
use App\Http\Controllers\Product\ProductCategoyController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductTransactionController;
use App\Http\Controllers\Seller\SellerBuyerController;
use App\Http\Controllers\Seller\SellerCategoryController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerTransactionController;
use App\Http\Controllers\Transaction\TransactionCategoryController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Transaction\TransactionSellerController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('buyers', BuyerController::class, ['only' => ['index', 'show']]);

Route::get('buyers/{buyer}/transactions', [BuyerTransactionController::class, 'index']);

Route::get('buyers/{buyer}/products', [BuyerProductController::class, 'index']);

Route::get('buyers/{buyer}/sellers', [BuyerSellerController::class, 'index']);

Route::get('buyers/{buyer}/categories', [BuyerCategoryController::class, 'index']);

Route::resource('categories', CategoryController::class, ['except' => ['create', 'edit']]);

Route::get('categories/{category}/products', [CategoryProductController::class, 'index']);

Route::get('categories/{category}/sellers', [CategorySellerController::class, 'index']);

Route::get('categories/{category}/transactions', [CategoryTransactionController::class, 'index']);

Route::get('categories/{category}/buyers', [CategoryBuyerController::class, 'index']);

Route::resource('products', ProductController::class, ['only' => ['index', 'show']]);

Route::resource('products.transactions', ProductTransactionController::class, ['only' => ['index']]);

Route::resource('products.buyers', ProductBuyerController::class, ['only' => ['index']]);

Route::resource('products.buyers.transactions', ProductBuyerTransactionController::class, ['only' => ['store', 'index']]);

Route::resource('products.categories', ProductCategoyController::class, ['only' => ['index', 'update', 'destroy']]);

Route::resource('sellers', SellerController::class, ['only' => ['index', 'show']]);

Route::get('sellers/{seller}/transactions', [SellerTransactionController::class, 'index']);

Route::get('sellers/{seller}/categories', [SellerCategoryController::class, 'index']);

Route::get('sellers/{seller}/buyers', [SellerBuyerController::class, 'index']);

Route::resource('sellers.products', SellerProductController::class, ['only' => ['show', 'index', 'store', 'destroy', 'update']]);

Route::resource('transactions', TransactionController::class, ['only' => ['index', 'show']]);

Route::get('transactions/{transaction}/categories', [TransactionCategoryController::class, 'index']);

Route::get('transactions/{transaction}/seller', [TransactionSellerController::class, 'index']);

Route::resource('users', UserController::class, ['except' => ['create', 'edit']]);

Route::name('verify')->get('users/verify/{token}', [UserController::class, 'verify']);
Route::name('resend')->get('users/{user}/resend', [UserController::class, 'resend']);
Route::post('login', [UserController::class, 'login']);
