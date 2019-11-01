<?php

namespace Softworx\RocXolid\UserManagement\Http\Controllers\User;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\UserManagement\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\UserManagement\Models\User;
use Softworx\RocXolid\UserManagement\Repositories\User\Repository;
use Softworx\RocXolid\UserManagement\Forms\User\Create;
use Softworx\RocXolid\UserManagement\Forms\User\Update;

class Controller extends AbstractCrudController
{
    protected static $model_class = User::class;

    protected static $repository_class = Repository::class;

    protected $translation_param = 'user';
    /*
    protected static $form_class = [
        'create' => CreateForm::class,
        'update' => UpdateForm::class,
    ];
    */
}