<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\CompanyProfile;

// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid form contracts
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
// rocXolid user management components
use Softworx\RocXolid\UserManagement\Components\ModelViewers\CompanyProfileViewer;
// rocXolid user management controllers
use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;

/**
 * Company profile controller.
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
    protected static $model_viewer_type = CompanyProfileViewer::class;

    /**
     * {@inheritDoc}
     */
    protected function successAjaxResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form): array
    {
        $model_viewer_component = $model->getModelViewerComponent();

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->replace($model_viewer_component->getDomId('user', 'company'), $model_viewer_component->fetch('related.show', [
                'attribute' => 'company',
                'relation' => 'user'
            ])) // @todo hardcoded, ugly
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $form->getParam()))) // @todo "hotfixed", modal dom id creation refactoring needed
            ->get();
    }
}
