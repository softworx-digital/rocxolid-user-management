<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\CompanyProfile;

/**
 * Company profile relation helper trait.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
trait HasCompanyProfile
{
    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation
     */
    public function company(): HasOne
    {
        return $this->hasOne(CompanyProfile::class);
    }
}
