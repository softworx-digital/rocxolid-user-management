<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Softworx\RocXolid\UserManagement\Models\CompanyProfile;

trait HasCompanyProfile
{
    public function company()
    {
        return $this->hasOne(CompanyProfile::class);
    }

    public function makeCompanyProfile()
    {
        return new CompanyProfile();
    }
}