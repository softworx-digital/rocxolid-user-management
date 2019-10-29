<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Hash;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// components
use Softworx\RocXolid\Components\General\Message;
// model traits
use Softworx\RocXolid\Models\Traits\Crudable as CrudableTrait;
// user management traits
use Softworx\RocXolid\UserManagement\Models\Traits\HasRoles;
use Softworx\RocXolid\UserManagement\Models\Traits\HasGroups;
use Softworx\RocXolid\UserManagement\Models\Traits\HasPermissions;
use Softworx\RocXolid\UserManagement\Models\Traits\HasUserProfile;
use Softworx\RocXolid\UserManagement\Models\Traits\ProtectsRoot;

/**
 * rocXolid User class.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Admin
 * @version 1.0.0
 */
class User extends Authenticatable implements Crudable
{
    use Notifiable;
    use CrudableTrait;
    use HasRoles;
    use HasGroups;
    use HasPermissions;
    use HasUserProfile;
    use ProtectsRoot;

    const ROOT_ID = 1;
    /**
     * Flag if model instances can be user deleted.
     *
     * @var boolean
     */
    protected static $can_be_deleted = true;

    protected static $title_column = 'name';

    protected $system = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $fillable = [
        'name',
        'email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $relationships = [
        'groups',
        'roles',
        'permissions',
    ];

    protected $extra = [];

    public function getTitle()
    {
        return $this->{$this->getTitleColumn()};
    }

    public function getTitleColumn()
    {
        return static::$title_column;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function fillCustom($data)
    {
        $this->login = $this->email;

        if (isset($data['password_unhashed']) && $data['password_unhashed'])
        {
            $this->password = $data['password_unhashed'];
            $this->password_unhashed = null;
        }

        return $this;
    }

    public function getLastAction()
    {
        return Carbon::parse($this->last_action)->format('j.n.Y H:i:s');
    }

    public function getDaysFirstLogin()
    {
        if (!is_null($this->days_first_login) && Carbon::parse($this->days_first_login)->isToday())
        {
            return Carbon::parse($this->days_first_login)->format('H:i');
        }
        else
        {
            return __('rocXolid::user.text.not-yet');
        }
    }

    public function getStatus($seconds = 3600)
    {
        $logged = is_null($this->logged_out) && Carbon::parse($this->last_action)->gt(Carbon::now()->subSeconds($seconds));

        return (new Message())->fetch(sprintf('status.%s', $logged ? 'on' : 'off'));
    }

    public function applyGroupFilters(&$builder, $column)
    {
        if (!$this->isRoot())
        {
            $webs = new Collection();

            $this->load(['groups.websNoneScope' => function($query) use (&$webs) {
                $webs = $query->get()->unique();
            }]);

            $builder->whereIn($column, $webs->pluck('id'));
        }

        return $this;
    }

    public function isRoot()
    {
        return $this->id == static::ROOT_ID;
    }
}