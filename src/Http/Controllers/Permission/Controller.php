<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\Permission;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
// rocXolid services
use Softworx\RocXolid\Services\PermissionScannerService;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
// rocXolid components
use Softworx\RocXolid\Components\General\Button;
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
    /**
     * {@inheritDoc}
     */
    protected static $model_class = Permission::class;

    /**
     * {@inheritDoc}
     */
    protected static $repository_class = Repository::class;

    /**
     * @var \Softworx\RocXolid\Services\PermissionScannerService
     */
    protected $permission_reader_service;

    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse $response
     * @param \Softworx\RocXolid\Services\PermissionScannerService $permission_reader_service
     * @return \Softworx\RocXolid\UserManagement\Http\Controllers\Permission\Controller
     */
    public function __construct(AjaxResponse $response, PermissionScannerService $permission_reader_service)
    {
        parent::__construct($response);

        $this->permission_reader_service = $permission_reader_service;
    }

    /**
     * {@inheritDoc}
     * @Softworx\RocXolid\Annotations\AuthorizedAction(policy_ability_group="read-only",policy_ability="viewAny",scopes="['policy.scope.all','policy.scope.owned']")
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
                $alert_component = $this->getSynchronizeAlertComponent($saved_permissions, $code_permissions);
            }
        } catch (FileNotFoundException $e) {
            $alert_component = $this->getErrorAlertComponent($e);
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
     * @Softworx\RocXolid\Annotations\AuthorizedAction(policy_ability_group="execute",policy_ability="synchronize")
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param string $param
     * @return mixed
     */
    public function synchronize(CrudRequest $request, string $param = null)
    {
        $this->authorize('synchronize', $this->getModelClass());

        $repository = $this->getRepository($this->getRepositoryParam($request));
        $repository_component = $this->getRepositoryComponent($repository);

        try {
            $code_permissions = $this->permission_reader_service->sourceCodePermissions();
            $saved_permissions = $this->permission_reader_service->persistentPermissions(static::$model_class::make());

            if (!$param || ($param === 'delete')) {
                $saved_permissions->diffRecords($code_permissions)->each(function($data) {
                    static::$model_class::where($data)->delete();
                });
            }

            if (!$param || ($param === 'insert')) {
                $code_permissions->diffRecords($saved_permissions)->each(function($data) {
                    static::$model_class::create($data);
                });
            }
        } catch (FileNotFoundException $e) {
            dd($e);
        }

        if ($request->ajax()) {
            return $this->response
                // ->replace($repository_component->getDomId(), $repository_component->fetch())
                ->redirect($this->getRoute('index'))
                ->get();
        } else {
            return redirect($this->getRoute('index'));
        }
    }

    /**
     * Build alert message stating out of sync permissions with corresponding actions.
     *
     * @param \Illuminate\Support\Collection $saved_permissions
     * @param \Illuminate\Support\Collection $code_permissions
     * @return \Softworx\RocXolid\Components\General\Alert
     */
    private function getSynchronizeAlertComponent(Collection $saved_permissions, Collection $code_permissions): Alert
    {
        $alert_component = Alert::build($this, $this)
            ->setType(Alert::TYPE_INFO)
            ->addTextKey('out-of-sync');

        $alert_component->addButton(Button::build($this, $this)
                ->setOptions([
                    'attributes' => [
                        'class' => 'btn btn-primary col-xs-12',
                        'data-ajax-url' => $this->getRoute('synchronize'),
                    ],
                    'label' => [
                        'icon' => 'fa fa-refresh',
                        'title' => $alert_component->translate(sprintf('button.synchronize')),
                    ],
                ])
            );

        // there are some persistent permissions not appliable after source code extraction
        if ($saved_permissions->diffRecords($code_permissions)->isNotEmpty()) {
            $alert_component
                ->addTextKey('out-of-sync-saved-code', 'strong')
                ->addCollection($saved_permissions->diffRecords($code_permissions)->pluck('name'))
                ->addButton(Button::build($this, $this)
                    ->setOptions([
                        'attributes' => [
                            'class' => 'btn btn-primary col-xs-12',
                            'data-ajax-url' => $this->getRoute('synchronize', [ 'param' => 'delete' ]),
                        ],
                        'label' => [
                            'icon' => 'fa fa-trash',
                            'title' => $alert_component->translate(sprintf('button.synchronize-delete')),
                        ],
                    ])
                );
        }

        // there are some not persisted source code extracted permissions
        if ($code_permissions->diffRecords($saved_permissions)->isNotEmpty()) {
            $alert_component
                ->addTextKey('out-of-sync-code-saved', 'strong')
                ->addCollection($code_permissions->diffRecords($saved_permissions)->pluck('name'))
                ->addButton(Button::build($this, $this)
                    ->setOptions([
                        'attributes' => [
                            'class' => 'btn btn-primary col-xs-12',
                            'data-ajax-url' => $this->getRoute('synchronize', [ 'param' => 'insert' ]),
                        ],
                        'label' => [
                            'icon' => 'fa fa-save',
                            'title' => $alert_component->translate(sprintf('button.synchronize-insert')),
                        ],
                    ])
                );
        }

        return $alert_component;
    }

    /**
     * Build error alert message.
     *
     * @param \Exception $e
     * @return \Softworx\RocXolid\Components\General\Alert
     */
    private function getErrorAlertComponent(\Throwable $e): Alert
    {
        return Alert::build($this, $this)
                ->setType(Alert::TYPE_ERROR)
                ->addText($e->getMessage());
    }
}
