<?php

namespace Softworx\RocXolid\UserManagement\Forms\Fields\Type;

use Log;
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

    public function getPermissionFieldName(Permission $permission, int $index = 0): string
    {
        if ($this->isArray()) {
            return sprintf('%s[%s][%s][%s][%s]', self::ARRAY_DATA_PARAM, $index, $this->name, $permission->getKeyName(), $permission->getKey());
        } else {
            return sprintf('%s[%s][%s][%s]', self::SINGLE_DATA_PARAM, $this->name, $permission->getKeyName(), $permission->getKey());
        }
    }

    public function getPermissionPivotFieldName(Permission $permission, string $attribute, int $index = 0): string
    {
        // @todo: awkward
        $relation = $this->getForm()->getController()->getModel()->{$this->name}();

        if ($this->isArray()) {
            return sprintf('%s[%s][%s][%s][%s][%s]', self::ARRAY_DATA_PARAM, $index, $this->name, $relation->getPivotAccessor(), $permission->getKey(), $attribute);
        } else {
            return sprintf('%s[%s][%s][%s][%s]', self::SINGLE_DATA_PARAM, $this->name, $relation->getPivotAccessor(), $permission->getKey(), $attribute);
        }
    }

    // @todo: refactor - put into some more general formfield
    public function setValue($data, int $index = 0): Valueable
    {
        $value = $data;

        // @todo: awkward
        $relation = $this->getForm()->getController()->getModel()->{$this->name}();
        $related = $relation->getRelated();

        // coming from submitted data
        if (is_array($data) && isset($data[$related->getKeyName()]) && is_array($data[$related->getKeyName()])) {
            $value = collect($data[$related->getKeyName()])->filter()->keys();

            // We need to process the data in the form
            // '<permission-id>' => [
            //      '<model>_id' => ...,
            //      'permission_id' => ...,
            //      ('data_1' => ...,)
            //      ...
            // ];
            // and set it to pivot data to be passed correctly by getFinalValue().
            $this->setPivotData(collect());
            $value->each(function($related_key) use ($data, $value, $relation) {
                if ($value->contains($related_key)) {
                    $pivot_data = collect($data[$relation->getPivotAccessor()] ?? [])->get($related_key);

                    $this->addNewPivot($relation, [
                        $relation->getForeignPivotKeyName() => $this->getForm()->getController()->getModel()->getKey(),
                        $relation->getRelatedPivotKeyName() => $related_key,
                    ] + ($pivot_data ?? []));
                }
            });
        }

        return parent::setValue($value, $index);
    }

    public function getFinalValue(): array
    {
        return $this->getPivotData()->toArray();
    }

    public function isFieldValue($value, $index = 0): bool
    {
        return $this->getFieldValue($index)->contains($value);
    }
}
