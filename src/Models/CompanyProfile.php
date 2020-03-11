<?php

namespace Softworx\RocXolid\UserManagement\Models;

// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid user management model traits
use Softworx\RocXolid\UserManagement\Models\Traits\BelongsToUser;

/**
 * rocXolid company profile class.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class CompanyProfile extends AbstractCrudModel
{
    use BelongsToUser;

    /**
     * {@inheritDoc}
     */
    protected static $can_be_deleted = false;

    /**
     * {@inheritDoc}
     */
    protected static $title_column = [
        'name',
    ];

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'user_id', // @todo: make it not needed in fillable
        'name',
        'email',
        'established',
        'company_registration_no',
        'company_insertion_no',
        'tax_no',
        'vat_no',
    ];

    /**
     * {@inheritDoc}
     */
    protected $system = [
        'id',
        'established', // @todo: so far
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * {@inheritDoc}
     */
    protected $dates = [
        'established',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
