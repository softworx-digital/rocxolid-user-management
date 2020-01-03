<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Carbon\Carbon;
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

    protected $system = [
        'id',
        'established',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $fillable = [
        'email',
        'user_id', // @todo: needed?
        'name',
        'established',
        'company_registration_no',
        'tax_no',
        'vat_no',
    ];

    public function fillCustom($data, $action = null)
    {
        $this->email = $this->user->email;

        return $this;
    }

    public function getAttributeViewValue($attribute)
    {
        switch ($attribute) {
            case 'established':
                return Carbon::make($this->$attribute)->format('j.n.Y');
            default:
                return $this->$attribute;
        }
    }

    // @todo: type hints
    protected function allowPermissionException($user, $method_group, $permission)
    {
        return !$this->exists || $this->user->is($user);
    }
}