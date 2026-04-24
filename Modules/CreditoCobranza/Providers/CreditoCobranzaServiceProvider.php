<?php

namespace Modules\CreditoCobranza\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class CreditoCobranzaServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('CreditoCobranza', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('CreditoCobranza', 'Config/config.php') => config_path('creditocobranza.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('CreditoCobranza', 'Config/config.php'), 'creditocobranza'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/creditocobranza');

        $sourcePath = module_path('CreditoCobranza', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/creditocobranza';
        }, \Config::get('view.paths')), [$sourcePath]), 'creditocobranza');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/creditocobranza');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'creditocobranza');
        } else {
            $this->loadTranslationsFrom(module_path('CreditoCobranza', 'Resources/lang'), 'creditocobranza');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('CreditoCobranza', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
