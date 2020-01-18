<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\Permission;

use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Support\Collection;
// rocXolid utilities
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid components
use Softworx\RocXolid\Components\General\Alert;
// rocXolid controller contracts
use Softworx\RocXolid\Http\Controllers\Contracts\Permissionable;
// rocXolid user management controller contracts
use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Permission;
// rocXolid user management repositories
use Softworx\RocXolid\UserManagement\Repositories\Permission\Repository;

use Softworx\RocXolid\Http\Controllers\Contracts\Crudable;

/**
 * CRUDable permission controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 */
class Controller extends AbstractCrudController
{
    protected static $model_class = Permission::class;

    protected static $repository_class = Repository::class;

    /**
     * {@inheritDoc}
     */
    public function index(CrudRequest $request)//: View
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));
        $repository_component = $this->getRepositoryComponent($repository);

        $alert_component = Alert::build($this, $this)
            ->setType(Alert::TYPE_INFO)
            ->setTextKey('out-of-sync');

        if ($request->ajax()) {
            return $this->response
                ->replace($repository_component->getDomId(), $repository_component->fetch())
                ->get();
        } else {
            return $this
                ->getDashboard()
                ->addAlertComponent($alert_component)
                ->setRepositoryComponent($repository_component)
                ->render('index');
        }
    }

    private function getPermissionableControllers(): Collection
    {
        return collect(ClassFinder::getClassesInNamespace('Softworx\RocXolid', ClassFinder::RECURSIVE_MODE))->filter(function($class) {
            $reflection = new \ReflectionClass($class);

            return $reflection->implementsInterface(Permissionable::class) && !$reflection->isAbstract();
        });
    }
}
