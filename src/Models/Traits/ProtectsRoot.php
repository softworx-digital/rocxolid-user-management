<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Softworx\RocXolid\UserManagement\Models\Scopes\ProtectingRoot;

trait ProtectsRoot
{
    public static function bootProtectsRoot()
    {
        if (($user = auth('rocXolid')->user()) && !$user->isRoot()) {
            static::addGlobalScope(new ProtectingRoot());
        }
    }
}
