<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Auth;
use Softworx\RocXolid\UserManagement\Models\Scopes\ProtectingRoot;

trait ProtectsRoot
{
    public static function bootProtectsRoot()
    {
        if (($user = Auth::guard('rocXolid')->user()) && ($user->getKey() != static::ROOT_ID)) {
            static::addGlobalScope(new ProtectingRoot());
        }
    }
}
