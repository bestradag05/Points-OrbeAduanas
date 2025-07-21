<?php

namespace App\Providers;

use App\Models\ResponseFreightQuotes;
use App\Models\User;
use App\Models\ResponseTransportQuote;
use App\Observers\QuoteTraceObserver;
use App\Observers\ResponseQuoteFreightObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $notifications = Auth::user()->unreadNotifications;
                // Extraemos los IDs únicos de usuarios que originaron las notificaciones
                $userIds = $notifications->pluck('data.oring_user')->unique()->filter();
                // Cargamos los usuarios de una sola consulta y los indexamos por ID
                $originUsers = User::whereIn('id', $userIds)->get()->keyBy('id');
                // Pasamos las variables a las vistas
                $view->with([
                    'notifications' => $notifications,
                    'originUsers' => $originUsers,
                ]);
            }
        });

       

    }
}
