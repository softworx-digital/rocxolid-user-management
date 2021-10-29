<?php

namespace Softworx\RocXolid\UserManagement\Components\ModelViewers;

use Illuminate\Support\Collection;
// rocXolid user management components
use Softworx\RocXolid\UserManagement\Components\ModelViewers\AbstractTabbedCrudModelViewer;

/**
 * User model viewer component.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class User extends AbstractTabbedCrudModelViewer
{
    /**
     * @inheritDoc
     */
    protected $tabs = [
        'default',
    ];

    /**
     * @inheritDoc
     */
    protected $panels = [
        'data' => [
            'general' => [
                'is_enabled',
                'type',
                'name',
                'surname',
                'phone_number',
                'language_id',
            ],
            'authentication' => [
                'email',
                'password',
            ],
            'company' => [
                'company',
                'company_registration_no',
                'company_insertion_no',
                'company_tax_no',
                'company_vat_no',
            ],
            'instagram' => [
                'instagram_url',
                'instagram_name',
                'instagram_post_count',
                'instagram_follower_count',
                'instagram_following_count',
                'instagram_audience_quality_id',
                'instagram_audience_gender_male',
                'instagram_audience_gender_female',
            ],
            'note' => [
                'note',
            ],
        ],
    ];

    /**
     * @inheritDoc
     */
    public function tabs(): Collection
    {
        $tabs = $this->tabs;

        if ($this->getModel()->getPreferencesType()) {
            $tabs[] = 'preferencets';
        }

        return collect($tabs);
    }
}
