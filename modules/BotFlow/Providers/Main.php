<?php

namespace Modules\BotFlow\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as Provider;
use Livewire\Livewire;

class Main extends Provider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadConfig();
        $this->loadRoutes();
    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
        $this->loadViews();
        $this->loadViewComponents();
        $this->loadTranslations();
        $this->loadMigrations();
        Livewire::component(
                'bot-flow.tables.filament.flow-bot-filament-table',
                \Modules\BotFlow\Http\Livewire\Tables\Filament\FlowBotFilamentTable::class
            );
        Livewire::component(
            'bot-flow.flow-bot.flow-list',
            \Modules\BotFlow\Http\Livewire\FlowBot\FlowList::class
        );

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'botflow');

        Blade::component('bot-flow::components.breadcrumb', 'breadcrumb');

    }

    /**
     * Load config.
     *
     * @return void
     */
    protected function loadConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'bot-flow'
        );
    }

    /**
     * Publish config.
     *
     * @return void
     */
    protected function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('bot-flow.php'),
        ], 'config');
    }

    /**
     * Load views.
     *
     * @return void
     */
    public function loadViews()
    {
        $viewPath = resource_path('views/modules/bot-flow');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/bot-flow';
        }, \Config::get('view.paths')), [$sourcePath]), 'bot-flow');
    }

    /**
     * Load view components.
     *
     * @return void
     */
    public function loadViewComponents()
    {
        Blade::componentNamespace('Modules\BotFlow\View\Components', 'bot-flow');
    }

    /**
     * Load translations.
     *
     * @return void
     */
    public function loadTranslations()
    {
        $langPath = resource_path('lang/modules/bot-flow');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'bot-flow');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang/en', 'bot-flow');
        }
    }

    /**
     * Load migrations.
     *
     * @return void
     */
    public function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Load routes.
     *
     * @return void
     */
    public function loadRoutes()
    {
        if (app()->routesAreCached()) {
            return;
        }

        $routes = [
            'web.php',
            'api.php',
        ];

        foreach ($routes as $route) {
            $this->loadRoutesFrom(__DIR__ . '/../Routes/' . $route);
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
