<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common model traits
use Softworx\RocXolid\Common\Models\Traits\HasLanguage;
use Softworx\RocXolid\Common\Models\Traits\HasNationality;
// rocXolid user management model traits
use Softworx\RocXolid\UserManagement\Models\Traits\BelongsToUser;

/**
 * rocXolid user profile class.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
class UserProfile extends AbstractCrudModel
{
    use BelongsToUser;
    use HasLanguage;
    use HasNationality;

    /**
     * {@inheritDoc}
     */
    protected static $title_column = [
        'first_name',
        'middle_name',
        'last_name',
    ];

    /**
     * {@inheritDoc}
     */
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

    /**
     * {@inheritDoc}
     */
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

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'language',
        'nationality',
    ];

    /**
     * {@inheritDoc}
     */
    protected $dates = [
        'birthdate',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * {@inheritDoc}
     */
    protected $enums = [
        'gender',
        'legal_entity',
    ];

    /**
     * {@inheritDoc}
     */
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        $this->email = $this->user->email;

        return parent::onCreateBeforeSave($data);
    }

    /**
     * {@inheritDoc}
     */
    public function fillCustom(Collection $data): Crudable
    {
        $this->user->update([
            'name' => $this->getTitle()
        ]);

        return parent::fillCustom($data);
    }

    /**
     * {@inheritDoc}
     */
    public function canBeDeleted(Request $request): bool
    {
        return false;
    }

    /**
     * Check if user (profile) is natural person.
     *
     * @return boolean
     */
    public function isNatural(): bool
    {
        return $this->legal_entity === 'natural';
    }

    /**
     * Check if user (profile) is juridical person.
     *
     * @return boolean
     */
    public function isJuridical(): bool
    {
        return $this->legal_entity === 'juridical';
    }
}
