<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\Permission;

use Str;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
// rocXolid services
use Softworx\RocXolid\Services\PackageService;
use Softworx\RocXolid\Services\PermissionReaderService;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
// rocXolid components
use Softworx\RocXolid\Components\General\Alert;
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

    public function __construct(AjaxResponse $response, PackageService $package_service, PermissionReaderService $permission_reader_service)
    {
        parent::__construct($response);

        $this->package_service = $package_service;
        $this->permission_reader_service = $permission_reader_service;
    }

    /**
     * {@inheritDoc}
     * @Softworx\RocXolid\Annotations\AuthorizedAction(policy_ability_group="read-only",policy_ability="viewAll")
     */
    public function index(CrudRequest $request)//: View
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));
        $repository_component = $this->getRepositoryComponent($repository);

        try {
            $code_permissions = $this->permission_reader_service->sourceCodePermissions();
            $saved_permissions = $this->permission_reader_service->persistentPermissions(static::$model_class::make());

            if (!$this->permission_reader_service->isSynchronized(
                $code_permissions,
                $saved_permissions
            )) {
                $alert_component = Alert::build($this, $this)
                    ->setController($this)
                    ->setRouteMethod('synchronize')
                    ->setType(Alert::TYPE_INFO)
                    ->addTextKey('out-of-sync')
                    ->addText($saved_permissions->diffRecords($code_permissions)->toJson(), 'pre')
                    ->addText($code_permissions->diffRecords($saved_permissions)->toJson(), 'pre');
            }
        } catch (FileNotFoundException $e) {
            $alert_component = Alert::build($this, $this)
                ->setType(Alert::TYPE_ERROR)
                ->addText($e->getMessage());
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
        $repository = $this->getRepository($this->getRepositoryParam($request));
        $repository_component = $this->getRepositoryComponent($repository);

        try {
            $code_permissions = $this->permission_reader_service->sourceCodePermissions();
            $saved_permissions = $this->permission_reader_service->persistentPermissions(static::$model_class::make());

            $saved_permissions->diffRecords($code_permissions)->each(function($data) {
                static::$model_class::where($data)->delete();
            });

            $code_permissions->diffRecords($saved_permissions)->each(function($data) {
                static::$model_class::create($data);
            });
        } catch (FileNotFoundException $e) {
            dd($e);
        }

        if ($request->ajax()) {
            return $this->response
                ->replace($repository_component->getDomId(), $repository_component->fetch())
                ->get();
        } else {
            return redirect($this->getRoute('index'));
        }
    }
}
