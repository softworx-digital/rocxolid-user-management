<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
// rocXolid fundamentals
use Softworx\RocXolid\Models\AbstractCrudModel;
// commerce models
use Softworx\RocXolid\Common\Models\Web;
// commerce scopes
use Softworx\RocXolid\Common\Models\Scopes\UserGroupAssociating;
// user management models
use Softworx\RocXolid\UserManagement\Models\User;
use Softworx\RocXolid\UserManagement\Models\Traits\HasPermissions;

/**
 *
 */
class Group extends AbstractCrudModel
{
    use HasPermissions;

    protected static $title_column = 'name';

    protected $fillable = [
        'name',
    ];

    protected $relationships = [
        'webs',
        //'permissions',
        'users',
    ];

    public function webs()
    {
        return $this->hasMany(Web::class, 'user_group_id');
    }

    public function websNoneScope()
    {
        return $this->hasMany(Web::class, 'user_group_id');
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'model', 'model_has_groups', 'group_id', 'model_id');
    }
}
