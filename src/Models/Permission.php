<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\Models\Traits\Crudable as CrudableTrait;
use Softworx\RocXolid\Models\Traits\HasTitleColumn;

// @todo - odrezat spatie
class Permission extends SpatiePermission implements Crudable
{
    use CrudableTrait;
    use HasTitleColumn;

    protected $hidden = [
        'id',
    ];

    protected $fillable = [
        'name',
        //'guard_name',
        'controller_class',
        'controller_method_group',
        'controller_method',
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
        list($param, $method_group) = explode('.', sprintf('%s.', $this->name));

        return sprintf('%s - %s', __(sprintf('rocXolid::permission.param.%s', $param)), __(sprintf('rocXolid::permission.method-group.%s', $method_group)));
    }
}
