<?php

namespace Christhompsontldr\Larauser;

use Illuminate\Routing\Router;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'AddTrait' => 'command.larauser.add-trait',
        'Migrations' => 'command.larauser.migrations',
        'Setup' => 'command.larauser.setup',
    ];

    public function boot()
    {
        // publish configs
        $this->publishes([
           realpath(dirname(__DIR__)) . '/config/larauser.php' => config_path('larauser.php'),
        ]);

        $this->loadViewsFrom(realpath(__DIR__ . '/resources/views'), 'larauser');

        if (!$this->app->routesAreCached()) {
            $this->setupRoutes($this->app->router);
        }
    }

    /**
     * Get the services provided.
     *
     * @return array
     */
    public function provides()
    {
        return array_values($this->commands);
    }

    /**
    * Register the providers that are used
    *
    */
    public function register()
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();

        $loader->alias('Form', 'Collective\Html\FormFacade');
        $loader->alias('Html', 'Collective\Html\HtmlFacade');

        $this->app->register('Collective\Html\HtmlServiceProvider');

        $this->registerCommands();
    }

    /**
     * Register the given commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        foreach (array_keys($this->commands) as $command) {
            $method = "register{$command}Command";
            call_user_func_array([$this, $method], []);
        }
        $this->commands(array_values($this->commands));
    }

    protected function registerAddTraitCommand()
    {
        $this->app->singleton($this->commands['AddTrait'], function () {
            return new AddTraitCommand();
        });
    }

    protected function registerMigrationsCommand()
    {
        $this->app->singleton($this->commands['Migrations'], function () {
            return new MigrationsCommand();
        });
    }

    protected function registerSetupCommand()
    {
        $this->app->singleton($this->commands['Setup'], function () {
            return new SetupCommand();
        });
    }

    /**
     * Define the routes for the package.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Christhompsontldr\Larauser\Http\Controllers'], function($router)
        {
            require __DIR__.'/Http/routes.php';
        });
    }
}