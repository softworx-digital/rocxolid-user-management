<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
//
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\UserManagement\Models\User;
use Softworx\RocXolid\UserManagement\Components\ModelViewers\UserViewer;

class Controller extends AbstractCrudController
{
    protected static $model_viewer_type = UserViewer::class;

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

    protected function successAjaxResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form)
    {
        $model_viewer_component = $model->getModelViewerComponent();

        $template_name = sprintf('include.%s', $request->_section);

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->replace($model_viewer_component->getDomId('header-panel'), $model_viewer_component->fetch('include.header-panel'))
            ->replace($model_viewer_component->getDomId($request->_section), $model_viewer_component->fetch($template_name))
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $form->getParam())))
            ->get();
    }
}
