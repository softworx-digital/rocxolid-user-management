<?php

namespace Softworx\RocXolid\UserManagement\Models\Contracts;

use Staudenmeir\EloquentHasManyDeep\HasManyDeep;

/**
 * Interface to enable permissions for a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
interface HasRolePermissions
{
    /**
     * A model role - permission relationship.
     *
     * @return \Staudenmeir\EloquentHasManyDeep\HasManyDeep
     */
    public function rolePermissions(): HasManyDeep;
}
