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
 * rocXolid user profile class.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Admin
 * @version 1.0.0
 */
class UserProfile extends AbstractCrudModel
{
    use BelongsToUser;
    use HasLanguage;
    use HasNationality;

    protected static $can_be_deleted = false;

    protected static $title_column = [
        'first_name',
        'middle_name',
        'last_name',
    ];

    protected $system = [
        'id',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $fillable = [
        'user_id',
        'language_id',
        'legal_entity',
        'email',
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'birthdate',
        'gender',
        'bank_account_no',
        'phone_no',
        'id_card_no',
        'passport_no',
    ];

    protected $relationships = [
        'language',
        'nationality',
    ];

    public function fillCustom($data, $action = null)
    {
        $this->email = $this->user->email;

        return $this;
    }

    public function getAttributeViewValue($attribute)
    {
        switch ($attribute) {
            case 'gender':
                return $this->getModelViewerComponent()->translate(sprintf('choice.%s.%s', $attribute, $this->$attribute));
            case 'legal_entity':
                return $this->getModelViewerComponent()->translate(sprintf('choice.%s.%s', $attribute, $this->$attribute));
            case 'birthdate':
                return Carbon::make($this->$attribute)->format('j.n.Y');
            default:
                return $this->$attribute;
        }
    }

    // @todo: type hint
    protected function allowPermissionException($user, $method_group, $permission)
    {
        return !$this->exists || $this->user->is($user);
    }
}