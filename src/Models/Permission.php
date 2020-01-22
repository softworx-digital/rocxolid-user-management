<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Role;
use Softworx\RocXolid\UserManagement\Models\user;

class Permission extends AbstractCrudModel
{
    protected static $can_be_deleted = true;

    protected $hidden = [
        'id',
    ];

    protected $fillable = [
        'is_enabled',
        'name',
        'guard',
        'package',
        'controller_class',
        'policy_ability_group',
        'policy_ability',
    ];

    protected $extra = [];

    protected $system = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function getTitle()
    {
        return app($this->controller_class)->translate('model.title.singular');
    }

    /**
     * Permission role rolationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Permission belongs user relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'model');
    }
}
