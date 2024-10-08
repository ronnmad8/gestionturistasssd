<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Product::class => ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-action', function ($user) {
            return $user->esAdministrador();
        });

        //Passport::routes();
        //Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        //Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        //Passport::enableImplicitGrant();

        //Passport::tokensCan([
        //     'purchase-product' => 'Crear transacciones para comprar productos determinados',
        //     'manage-products' => 'Crear, ver, actualizar y eliminar productos',
        //     'manage-account' => 'Obtener la informacion de la cuenta, nombre, email, estado (sin contraseña), modificar datos como email, nombre y contraseña. No puede eliminar la cuenta',
        //     'read-general' => 'Obtener información general, categorías donde se compra y se vende, productos vendidos o comprados, transacciones, compras y ventas',
        //]);
    }
}
