<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\UserProfile;

// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid form contracts
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
// rocXolid user management components
use Softworx\RocXolid\UserManagement\Components\ModelViewers\UserProfileViewer;
// rocXolid user management controllers
use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;

/**
 * User profile controller.
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
    protected static $model_viewer_type = UserProfileViewer::class;

    /**
     * {@inheritDoc}
     */
    protected function successAjaxResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form): array
    {
        $model_viewer_component = $model->getModelViewerComponent();
        $user_model_viewer_component = $model->user->getModelViewerComponent();

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->replace($model_viewer_component->getDomId('user', 'profile'), $model_viewer_component->fetch('related.show', [
                'attribute' => 'profile',
                'relation' => 'user'
            ])) // @todo hardcoded, ugly
            ->replace($user_model_viewer_component->getDomId('header-panel'), $user_model_viewer_component->fetch('include.header-panel'))
            ->replace($user_model_viewer_component->getDomId('name', 'topbar'), $user_model_viewer_component->fetch('snippet.name', [ 'param' => 'topbar' ]))
            ->replace($user_model_viewer_component->getDomId('name', 'sidebar'), $user_model_viewer_component->fetch('snippet.name', [ 'param' => 'sidebar' ]))
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $form->getParam()))) // @todo "hotfixed", modal dom id creation refactoring needed
            ->get();
    }
}
