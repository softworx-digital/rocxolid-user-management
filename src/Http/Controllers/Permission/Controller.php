<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\Permission;

use Str;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
// rocXolid services
use Softworx\RocXolid\Services\PackageService;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
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

    protected $package_service;

    public function __construct(AjaxResponse $response, PackageService $package_service)
    {
        parent::__construct($response);

        $this->package_service = $package_service;
    }

    /**
     * {@inheritDoc}
     */
    public function index(CrudRequest $request)//: View
    {
// dump($this->package_service->rocxolidPackages());
        $repository = $this->getRepository($this->getRepositoryParam($request));
        $repository_component = $this->getRepositoryComponent($repository);

        try {
            $permissionable = collect()
                ->merge($this->getPermissionableControllers('Softworx\\RocXolid\\'))
                ->merge($this->getPermissionableControllers('App\\'));

            $alert_component = Alert::build($this, $this)
                ->setController($this)
                ->setRouteMethod('synchronize')
                ->setType(Alert::TYPE_INFO)
                ->setTextKey('out-of-sync');
        } catch (FileNotFoundException $e) {
            $alert_component = Alert::build($this, $this)
                ->setType(Alert::TYPE_ERROR)
                ->setText($e->getMessage());
        }

        if ($request->ajax()) {
            return $this->response
                ->replace($repository_component->getDomId(), $repository_component->fetch())
                ->get();
        } else {
            $dashboard = $this
                ->getDashboard()
                ->setRepositoryComponent($repository_component);

            if (isset($alert_component)) {
                $dashboard->addAlertComponent($alert_component);
            }

            return $dashboard->render('index');
        }
    }

    /**
     * Synchronize persistent permissions with extracted from source code.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     */
    public function synchronize(CrudRequest $request)
    {
dd(__METHOD__);
    }

    private function getPermissionableControllers(string $namespace): Collection
    {
        return $this->package_service->getPackageClasses($namespace, function($class) {
            $reflection = new \ReflectionClass($class);

            return $reflection->implementsInterface(Permissionable::class) && !$reflection->isAbstract();
        });
    }
}
