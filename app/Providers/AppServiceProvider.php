<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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

        //Esto es solo para el modo DESARROLLO. Eliminar del modo Produccion
//        DB::listen(function ($query) {
//             echo ($query->sql);
//            // $query->bindings
//            // $query->time
//        });



//Otra forma de ver las consultas ejecutandose. Funciona en Laravel 5. No se en Laravel 6
//        DB::enableQueryLog();
//        $log = DB::getQueryLog();
//        var_dump($log);
//// Multiples conexiones
//        DB::connection('connection1')->enableQueryLog();
//        DB::connection('connection1')->getQueryLog();
//        DB::connection('connection2')->enableQueryLog();
//        DB::connection('connection2')->getQueryLog();
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
