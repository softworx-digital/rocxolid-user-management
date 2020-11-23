<?php

namespace Softworx\RocXolid\UserManagement\Services;

use Illuminate\Support\Collection;
// rocXolid scopes
use Softworx\RocXolid\Models\Scopes\IsEnabled;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Permission;

/**
 * Service to retrieve persisted permissions.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class PermissionLoaderService
{
    protected static $sort = [
        'full' => 0,
        'viewAny' => 1,
        'view' => 2,
        'create' => 3,
        'update' => 4,
        'delete' => 5,
    ];

    public function __construct()
    {
        Permission::addGlobalScope(new IsEnabled);
    }

    /**
     * Get all enabled permissions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get(): Collection
    {
        return Permission::all()->groupBy('package');
    }

    /**
     * Check if there are some permissions registered for given package.
     *
     * @param string $package_class Package service provider class name.
     * @return bool
     */
    public function packageHasPermissions(string $package): bool
    {
        return Permission::where('is_enabled', 1)
            ->where('package', $package::getPackageKey())
            ->whereNull('attribute')
            ->count() > 0;
    }

    /**
     * Get registered permissions for given package.
     *
     * @param string $package_class Package service provider class name.
     * @return \Illuminate\Support\Collection
     */
    public function packagePermissions(string $package): Collection
    {
        return Permission::where('is_enabled', 1)
            ->where('package', $package::getPackageKey())
            ->whereNull('attribute')
            ->groupBy('controller_class')
            ->get();
    }

    /**
     * Sort permission abilities.
     *
     * @param \Illuminate\Support\Collection $permissions Controller permissions.
     * @return \Illuminate\Support\Collection
     */
    public function sortByAbilities(Collection $permissions): Collection
    {
        return $permissions->sortBy(function ($permission, $key) {
            return static::$sort[$permission['policy_ability']] ?? 999;
        });
    }
}
