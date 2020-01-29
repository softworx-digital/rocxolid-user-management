<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Softworx\RocXolid\Models\AbstractCrudModel;
// common traits
use Softworx\RocXolid\Common\Models\Traits\HasLanguage;
use Softworx\RocXolid\Common\Models\Traits\HasNationality;
// user management models
use Softworx\RocXolid\UserManagement\Models\User;
// user management traits
use Softworx\RocXolid\UserManagement\Models\Traits\BelongsToUser;

/**
 * rocXolid company profile class.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Admin
 * @version 1.0.0
 */
class CompanyProfile extends AbstractCrudModel
{
    use BelongsToUser;

    protected static $can_be_deleted = false;

    protected static $title_column = [
        'name',
    ];

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

    public function getAttributeViewValue($attribute)
    {
        switch ($attribute) {
            case 'established':
                return Carbon::make($this->$attribute)->format('j.n.Y');
            default:
                return $this->$attribute;
        }
    }
}
