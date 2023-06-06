<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Room;
use Illuminate\Pagination\Paginator;
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
        $page_data =Page::where('id',1)->first() ;
        $room_data = Room::get();
        view()->share('global_page_data',$page_data);
        view()->share('global_room_data',$room_data);
        Paginator::useBootstrap() ;

    }
}
