<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\UserProfile;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\UserManagement\Models\UserProfile;
use Softworx\RocXolid\UserManagement\Components\ModelViewers\UserProfileViewer;

class Controller extends AbstractCrudController
{
    protected static $model_viewer_type = UserProfileViewer::class;

    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
    ];

    protected function successAjaxResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form)
    {
        $model_viewer_component = $model->getModelViewerComponent();
        $user_model_viewer_component = $model->user->getModelViewerComponent();

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->replace($model_viewer_component->getDomId(), $model_viewer_component->fetch('related.show', [
                'attribute' => 'profile',
                'relation' => 'user'
            ])) // @todo: hardcoded, ugly
            ->replace($user_model_viewer_component->getDomId('header-panel'), $user_model_viewer_component->fetch('include.header-panel'))
            ->replace($user_model_viewer_component->getDomId('name', 'topbar'), $user_model_viewer_component->fetch('snippet.name', [ 'param' => 'topbar' ]))
            ->replace($user_model_viewer_component->getDomId('name', 'sidebar'), $user_model_viewer_component->fetch('snippet.name', [ 'param' => 'sidebar' ]))
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $form->getParam()))) // @todo: "hotfixed", modal dom id creation refactoring needed
            ->get();
    }
}
