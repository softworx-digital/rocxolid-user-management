<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Softworx\RocXolid\UserManagement\Models\UserProfile;

trait HasUserProfile
{
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
}