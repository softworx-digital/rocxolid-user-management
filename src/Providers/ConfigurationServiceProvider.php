<?php

namespace Softworx\RocXolid\UserManagement\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * rocXolid configuration service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class ConfigurationServiceProvider extends IlluminateServiceProvider
{
    /**
     * @var array $config_files Configuration files to be published and loaded.
     */
    protected $config_files = [
        'rocXolid.user-management.general' => '/../../config/general.php',
        'rocXolid.user-management.user' => '/../../config/user.php',
    ];

    /**
     * Register configuration provider for rocXolid User Management package.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function register(): IlluminateServiceProvider
    {
        $this
            ->configure();

        return $this;
    }

    /**
     * Set configuration files for loading.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function configure(): IlluminateServiceProvider
    {
        foreach ($this->config_files as $key => $path) {
            $path = realpath(__DIR__ . $path);

            if (file_exists($path)) {
                $this->mergeConfigFrom($path, $key);
            }
        }

        return $this;
    }
}
