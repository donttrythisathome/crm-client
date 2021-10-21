<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace Donttrythisathome\CRMClient;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/crm.php', 'crm');
        $this->registerCRMManager();
    }

    protected function registerCRMManager()
    {
        $this->app->singleton(CRMManager::class, function (Application $app) {
            return new CRMManager($app['config']['crm']);
        });
    }
}