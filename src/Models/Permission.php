<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Role;
use Softworx\RocXolid\UserManagement\Models\user;

/**
 * Permission model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Permission extends AbstractCrudModel
{
    /**
     * {@inheritDoc}
     */
    protected $hidden = [
        'id',
    ];

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_enabled',
        'name',
        'guard',
        'package',
        'controller_class',
        'model_class',
        'attribute',
        'policy_ability_group',
        'policy_ability',
        'scopes',
    ];

    /**
     * {@inheritDoc}
     */
    protected $extra = [];

    /**
     * {@inheritDoc}
     */
    protected $system = [
        'guard',
        'package',
        'controller_class',
        'model_class',
        'attribute',
        'policy_ability_group',
        'policy_ability',
        'scopes',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * @todo: Laravel 7
     */
    protected $casts = [
        'scopes' => 'array'
    ];

    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {
        return $this->name;
        /*
        if ($this->controller_class) {
            return sprintf(
                '%s - %s',
                app($this->controller_class)->translate('model.title.singular'),
                $this->getCrudController()->translate(sprintf('permissions.%s', $this->policy_ability))
            );
        }
        */
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

    /**
     * Check if some scopes can apply to the permission.
     *
     * @return bool
     */
    public function hasScopes(): bool
    {
        return !empty($this->scopes);
    }

    /**
     * Get scopes that can apply for permission.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getScopes(): Collection
    {
        return collect($this->scopes);
    }
}
