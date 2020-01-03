<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\User;

use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Http\Controllers\Traits\CanUploadImage;
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Repositories\Contracts\Repository as RepositoryContract;
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\UserManagement\Models\User;
use Softworx\RocXolid\UserManagement\Repositories\User\Repository;
use Softworx\RocXolid\UserManagement\Components\ModelViewers\UserViewer;

class Controller extends AbstractCrudController
{
    use CanUploadImage;

    protected static $model_class = User::class;

    protected static $repository_class = Repository::class;

    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'edit.authentication-data' => 'update-authentication',
        'update.authentication-data' => 'update-authentication',
        'edit.authorization-data' => 'update-authorization',
        'update.authorization-data' => 'update-authorization',
    ];

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return UserViewer::build($this, $this)
            ->setModel($model)
            ->setController($this);
    }

    protected function successResponse(CrudRequest $request, RepositoryContract $repository, AbstractCrudForm $form, CrudableModel $model, string $action)
    {
        if ($request->ajax() && $request->has('_section'))
        {
            $user_model_viewer_component = $model->getModelViewerComponent();

            $template_name = sprintf('include.%s', $request->_section);

            return $this->response
                ->notifySuccess($user_model_viewer_component->translate('text.updated'))
                ->replace($user_model_viewer_component->getDomId($request->_section), $user_model_viewer_component->fetch($template_name))
                ->modalClose($user_model_viewer_component->getDomId(sprintf('modal-%s', $action)))
                ->get();
        }
        else
        {
            return parent::successResponse($request, $repository, $form, $model, $action);
        }
    }

    // @todo: type hints
    protected function allowPermissionException($user, $action, $permission, CrudableModel $model = null)
    {
        $data = collect(request()->route()->parameters());

        if ($data->has('user')) {
            return $this->getRepository()->findOrFail($data->get('user'))->is($user);
        }

        if ($data->has('id')) {
            return $this->getRepository()->findOrFail($data->get('id'))->is($user);
        }

        return false;
    }
}