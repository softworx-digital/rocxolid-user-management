<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Softworx\RocXolid\Models\AbstractCrudModel;
// common traits
use Softworx\RocXolid\Common\Models\Traits\HasLanguage;
use Softworx\RocXolid\Common\Models\Traits\HasNationality;
// user management models
use Softworx\RocXolid\UserManagement\Models\User;
// user management traits
use Softworx\RocXolid\UserManagement\Models\Traits\HasUser;

/**
 * rocXolid User Profile class.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Admin
 * @version 1.0.0
 */
class UserProfile extends AbstractCrudModel
{
    use HasUser;
    use HasLanguage;
    use HasNationality;

    protected static $title_column = [
        'first_name',
        'middle_name',
        'last_name',
    ];

    protected $fillable = [
        'name',
        'email',
        'first_name',
        'middle_name',
        'last_name',
        'company_name',
        'birthdate',
        'gender',
        'bank_account_no',
        'phone_no',
        'id1_no',
        'id2_no',
        'vat_no',
    ];

    protected $relationships = [
        'language',
        'nationality',
    ];
}