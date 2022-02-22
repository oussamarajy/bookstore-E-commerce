<?php

namespace App\Providers;

use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Message;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

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

        Paginator::useBootstrap();
        view()->composer('*', function ($view)
    {

        $categorieshome = Categorie::all();

        $view->with([


            'categorieshome' => $categorieshome,

        ]);

    });

        view()->composer('*', function ($view)
    {
        $id = 0;
        if(Auth::check()){
            $id = Auth::user()->id;
        }


        $vu = Commande::all()->where('deja_vu', 0);
        $message = Message::all()->where('to_id', $id)->where('statue', false);
        $view->with([

            'countvu'=> $vu,
            'countMessages' => $message
        ]);

    });


    }



}
