<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\CompanyProfile;

use Illuminate\Foundation\Auth\User as Authenticatable;
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
        if ($request->ajax()) {
            $model_viewer_component = $model->getModelViewerComponent();

            return $this->response
                ->notifySuccess($model_viewer_component->translate('text.updated'))
                ->replace($model_viewer_component->getDomId(), $model_viewer_component->fetch('related.show', [
                    'attribute' => 'company',
                    'relation' => 'user'
                ])) // @todo: hardcoded, ugly
                ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $action)))
                ->get();
        } else {
            return parent::successResponse($request, $repository, $form, $model, $action);
        }
    }
}
