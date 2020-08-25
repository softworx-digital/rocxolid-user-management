<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid user management model traits
use Softworx\RocXolid\UserManagement\Models\Traits\BelongsToUser;
// app models
use App\Models\EnumCompanyRegistrationCourt; // @todo: this doesn't belong here

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
        'company_registration_court_id',
        'company_insertion_division',
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

    protected $relationships = [
        'companyRegistrationCourt',
    ];

    /**
     * {@inheritDoc}
     */
    public function canBeDeleted(Request $request): bool
    {
        return false;
    }

    public function companyRegistrationCourt(): BelongsTo
    {
        return $this->belongsTo(EnumCompanyRegistrationCourt::class);
    }
}
