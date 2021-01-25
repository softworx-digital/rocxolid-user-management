<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\User;

// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid form contracts
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
// rocXolid user management components
use Softworx\RocXolid\UserManagement\Components\ModelViewers\UserViewer;
// rocXolid user management controllers
use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;

/**
 * User controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class Controller extends AbstractCrudController
{
    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = UserViewer::class;

    /**
     * {@inheritDoc}
     */
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

    /**
     * {@inheritDoc}
     */
    protected function successAjaxResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form): array
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
