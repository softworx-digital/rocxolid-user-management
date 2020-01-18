<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\Permission;

use Softworx\RocXolid\Http\Controllers\Contracts\Permissionable;
use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\UserManagement\Models\Permission;
use Softworx\RocXolid\UserManagement\Repositories\Permission\Repository;

use Softworx\RocXolid\Http\Controllers\Contracts\Crudable;

use Softworx\RocXolid\Http\Requests\CrudRequest;

class Controller extends AbstractCrudController
{
    protected static $model_class = Permission::class;

    protected static $repository_class = Repository::class;

    public function index(CrudRequest $request)//: View
    {
        $classes = collect(get_declared_classes())->filter(function($class) {
            return (new \ReflectionClass($class))->implementsInterface(Crudable::class);
        });

        dd($classes);
    }
}
