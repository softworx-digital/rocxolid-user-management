<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common model traits
use Softworx\RocXolid\Common\Models\Traits\HasLanguage;
use Softworx\RocXolid\Common\Models\Traits\HasNationality;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\User;
// rocXolid user management model traits
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
        'user_id', // @todo: make it not needed in fillable
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

    // @todo: ugly
    public function fillCustom($data, $action = null)
    {
        $this->email = $this->user->email;

        $this->user->name = $this->getTitle();
        $this->user->save();

        return $this;
    }

    public function getAttributeViewValue(string $attribute)
    {
        switch ($attribute) {
            case 'gender':
                return $this->getModelViewerComponent()->translate(sprintf('choice.%s.%s', $attribute, $this->$attribute));
            case 'legal_entity':
                return $this->getModelViewerComponent()->translate(sprintf('choice.%s.%s', $attribute, $this->$attribute));
            case 'birthdate':
                return $this->$attribute ? Carbon::make($this->$attribute)->format('j.n.Y') : null;
            default:
                return $this->$attribute;
        }
    }
}
