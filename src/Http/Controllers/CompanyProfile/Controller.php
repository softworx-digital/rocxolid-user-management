<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\CompanyProfile;

use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Repositories\Contracts\Repository as RepositoryContract;
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\UserManagement\Models\CompanyProfile;
use Softworx\RocXolid\UserManagement\Repositories\CompanyProfile\Repository;
use Softworx\RocXolid\UserManagement\Components\ModelViewers\CompanyProfileViewer;

class Controller extends AbstractCrudController
{
    protected static $model_class = CompanyProfile::class;

    protected static $repository_class = Repository::class;

    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
    ];

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return CompanyProfileViewer::build($this, $this)
            ->setModel($model)
            ->setController($this);
    }

    protected function successResponse(CrudRequest $request, RepositoryContract $repository, AbstractCrudForm $form, CrudableModel $model, string $action)
    {
        if ($request->ajax())
        {
            $model_viewer_component = $model->getModelViewerComponent();

            return $this->response
                ->notifySuccess($model_viewer_component->translate('text.updated'))
                ->replace($model_viewer_component->getDomId(), $model_viewer_component->fetch())
                ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $action)))
                ->get();
        }
        else
        {
            return parent::successResponse($request, $repository, $form, $model, $action);
        }
    }

    // @todo: type hints
    // @todo: hotfixed
    protected function allowPermissionException($user, $action, $permission, CrudableModel $model = null)
    {
        $data = collect(request()->get('_data'));

        if ($data->has('user_id')) {
            return $data->get('user_id') == $user->id;
        }

        $data = collect(request()->route()->parameters());

        if ($data->has('company_profile')) {
            return $this->getRepository()->findOrFail($data->get('company_profile'))->user->is($user);
        }

        if ($data->has('id')) {
            return $this->getRepository()->findOrFail($data->get('id'))->user->is($user);
        }

        return false;
    }
}