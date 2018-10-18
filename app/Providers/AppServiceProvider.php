<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Barang;
use App\Penjualan;
use View;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Schema::defaultStringLength(191);

        View::composer('*', function($view){
            $notif = Barang::WhereColumn([['qty', '<=', 'batas_habis'], ['qty', '>', 'wajib_beli']])->get();
            $notifWajib = Barang::WhereColumn('qty', '<=', 'wajib_beli')->get();

            $view->with('notif', $notif);
            $view->with('notifWajib', $notifWajib);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
