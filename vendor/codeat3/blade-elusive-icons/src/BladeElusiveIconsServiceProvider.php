<?php

declare(strict_types=1);

namespace Codeat3\BladeElusiveIcons;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class BladeElusiveIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-elusive-icons', []);

            $factory->add('elusive-icons', array_merge(['path' => __DIR__ . '/../resources/svg'], $config));
        });
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blade-elusive-icons.php', 'blade-elusive-icons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/svg' => public_path('vendor/blade-elusive-icons'),
            ], 'blade-elusive-icons');

            $this->publishes([
                __DIR__ . '/../config/blade-elusive-icons.php' => $this->app->configPath('blade-elusive-icons.php'),
            ], 'blade-elusive-icons-config');
        }
    }
}
