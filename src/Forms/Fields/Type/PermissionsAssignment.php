<?php

namespace Softworx\RocXolid\UserManagement\Forms\Fields\Type;

// rocXolid contracts
use Softworx\RocXolid\Contracts\Valueable;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type\CollectionRadioList;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Permission;

class PermissionsAssignment extends CollectionRadioList
{
    protected $default_options = [
        'view-package' => 'rocXolid:user-management',
        'template' => 'permissions-assignment.default',
        // field wrapper
        'wrapper' => [
            'attributes' => [
                // 'class' => 'well well-sm bg-info',
            ],
        ],
        // field label
        'label' => false,
        // field HTML attributes
        'attributes' => [
        ],
    ];

    public function getPermissionFieldName(Permission $permission, $index = 0)
    {
        if ($this->isArray()) {
            return sprintf('%s[%s][%s][%s]', self::ARRAY_DATA_PARAM, $index, $this->name, $permission->id);
        } else {
            return sprintf('%s[%s][%s]', self::SINGLE_DATA_PARAM, $this->name, $permission->id);
        }
    }

    public function setValue($value, int $index = 0): Valueable
    {
        // coming from submitted data
        if (is_array($value)) {
            $value = collect($value)->filter()->keys();
        }

        return parent::setValue($value, $index);
    }

    public function isFieldValue($value, $index = 0)
    {
        return $this->getFieldValue($index)->contains($value);
    }
}
