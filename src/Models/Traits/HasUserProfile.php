<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\UserProfile;

/**
 * User profile relation helper trait.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
trait HasUserProfile
{
    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }
}
