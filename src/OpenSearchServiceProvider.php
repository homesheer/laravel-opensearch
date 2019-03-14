<?php

namespace HomeSheer\OpenSearch;

class OpenSearchServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/open_search.php' => config_path('open_search.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/config/open_search.php';
        $this->mergeConfigFrom($configPath, 'open_search');
    }

}
