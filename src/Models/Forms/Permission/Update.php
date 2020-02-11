<?php

namespace Softworx\RocXolid\UserManagement\Models\Forms\Permission;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        unset($fields['guard']);
        unset($fields['package']);
        unset($fields['controller_class']);
        unset($fields['model_class']);
        unset($fields['attribute']);
        unset($fields['policy_ability_group']);
        unset($fields['policy_ability']);
        unset($fields['scopes']);

        return $fields;
    }
}
