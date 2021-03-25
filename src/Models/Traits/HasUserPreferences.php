<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * User preferences relation helper trait.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
trait HasUserPreferences
{
    /**
     * Obtain class to handle user preferences.
     *
     * @return string|null
     */
    public function getPreferencesType(): ?string
    {
        return config('rocXolid.user-management.user.preferences', null);
    }

    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation
     */
    public function preferences(): HasOne
    {
        return $this->hasOne($this->getPreferencesType());
    }
}
