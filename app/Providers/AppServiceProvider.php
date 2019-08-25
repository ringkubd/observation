<?php

namespace App\Providers;

use App\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        View::composer('inc.header',function ($view){
            $branchArray = Auth::user()->branch->pluck("id")->toArray();
            $branch = Branch::whereIn("id",$branchArray)->whereIsdelete("0")->get();
            $view->with("branch",$branch);
        });
        View::composer('dashboard.inc.header',function ($view){
            $branchArray = Auth::user()->branch->pluck("id")->toArray();
            $branch = Branch::whereIn("id",$branchArray)->whereIsdelete("0")->get();
            $view->with("branch",$branch);
        });

    }
}
