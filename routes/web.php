<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

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
    $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
    return $categories;
    // $product->categories->attach($categories);
});

Route::get('/', function (): View {
    return view('test-email');
});
