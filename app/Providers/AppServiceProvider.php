<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //? Global Formatting Money
        Blade::directive('money', function ($money) {
            return "Rp. <?php echo number_format($money, 0,',','.'); ?>";
        }); 

        //? Global Variable Cart
        view()->composer('*', function ($view) {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $view->with('cartItems', Cart::where('users_id', $userId)->count());
        } else {
            $view->with('cartItems', 0);
        }
    });

        //? Gate Authorization isAdmin
        Gate::define('isAdmin', function ($user) {
        return $user->hasRole('admin');
    });
    }
}
