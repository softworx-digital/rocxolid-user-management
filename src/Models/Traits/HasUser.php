<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Softworx\RocXolid\UserManagement\Models\User;

trait HasUser
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}