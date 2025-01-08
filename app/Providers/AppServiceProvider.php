<?php

namespace App\Providers;

use App\Models\User;
use App\Notifications\NewUserRegisteredToAdmin;
use App\Notifications\WelcomeNewUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
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
     * Sirve para registrar proveedores de servicios
     */
    public function boot(): void
    {
        Event::listen(Registered::class, function ($event) {
            // Notificar al nuevo usuario registrado
            $event->user->notify(new WelcomeNewUser());

            // Obtener todos los administradores (usuarios con el rol 'admin')
            $admins = User::role('AdminTecnológico')->get();

            // Notificar a cada administrador
            foreach ($admins as $admin) {
                $admin->notify(new NewUserRegisteredToAdmin($event->user));
            }
        });

        // Implicitly grant "Super Admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::after(function ($user, $ability) {
            return $user->hasRole('SuperUsuario');
        });
    }
}
