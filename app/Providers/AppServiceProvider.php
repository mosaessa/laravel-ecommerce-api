<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        User::created(function ($user) {
            Mail::to($user)->send(new UserCreated($user));
        });
        // Product::updated(function ($product) {
        //     if ($product->quantity == 0 && $product->isAvailable()) {
        //         $product->status = Product::UNAVAILABLE_PRODUCT;
        //         $product->save();
        //         dd('ee');
        //     }
        //     dd($product);
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
