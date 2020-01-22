<?php

namespace Softworx\RocXolid\UserManagement\Forms\Fields\Type;

use Softworx\RocXolid\Helpers\View as ViewHelper;
use Softworx\RocXolid\Forms\Fields\AbstractFormField;

class PermissionsAssignment extends AbstractFormField
{
    protected $default_options = [
        'view-package' => 'rocXolid:user-management',
        'type-template' => 'permissions-assignment',
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

    protected function setAjax($ajax): FormField
    {
        $this
            ->setComponentOptions('ajax', true)
            ->setComponentOptions('attributes', [
                'data-ajax-submit-form' => sprintf('#%s', $this->form->getOption('component.id')),
                //'data-ajax-submit-form' => ViewHelper::domIdHash($this->form, 'form'),
                'type' => 'button',
            ]);

        return $this;
    }
}
