<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\UserProfile;

use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Repositories\Contracts\Repository as RepositoryContract;
use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\UserManagement\Models\UserProfile;
use Softworx\RocXolid\UserManagement\Repositories\UserProfile\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = UserProfile::class;

    protected static $repository_class = Repository::class;

    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'create.profile-data' => 'create-in-user',
        'store.profile-data' => 'create-in-user',
        'edit.profile-data' => 'update-in-user',
        'update.profile-data' => 'update-in-user',
    ];

    protected function successResponse(CrudRequest $request, RepositoryContract $repository, AbstractCrudForm $form, CrudableModel $model, string $action)
    {
        if ($request->ajax() && $request->has('_section'))
        {
            $user_profile_model_viewer_component = $model->getModelViewerComponent();
            $user_model_viewer_component = $model->user->getModelViewerComponent();

            $template_name = sprintf('include.%s', $request->_section);

            return $this->response
                ->replace($user_model_viewer_component->getDomId($request->_section), $user_model_viewer_component->fetch($template_name))
                ->modalClose($user_profile_model_viewer_component->getDomId(sprintf('modal-%s', $action)))
                ->get();
        }
        else
        {
            return parent::successResponse($request, $repository, $form, $order_delivery, $action);
        }
    }
}