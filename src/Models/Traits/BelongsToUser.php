<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Softworx\RocXolid\UserManagement\Models\User;

trait BelongsToUser
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}