<?php
namespace RocketsLab\WALaravel;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use RocketsLab\WALaravel\Console\Commands\InstallServerCommand;
use RocketsLab\WALaravel\Console\Commands\StartServerCommand;
use RocketsLab\WALaravel\Events\WAEventSubscriber;

class WALaravelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__. '/../config/walaravel.php',
            'walaravel'
        );

        if(config('walaravel.register_events')) {
            Event::subscribe(WAEventSubscriber::class);
        }
    }

    public function boot()
    {
        $this->registerCommands();

        $this->publishesConfig();

        $this->registerRoutes();

    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                StartServerCommand::class,
                InstallServerCommand::class,
            ]);
        }
    }

    protected function publishesConfig()
    {
        $this->publishes([
            __DIR__. '/../config/walaravel.php' => config_path('walaravel.php'),
        ]);
    }

    protected function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/connection.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/messages.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
