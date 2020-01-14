<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Hash;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Notifications\ResetPassword;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\Models\Contracts\HasTokenablePropertiesMethods;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits\Crudable as CrudableTrait;
use Softworx\RocXolid\Models\Traits\HasTitleColumn;
use Softworx\RocXolid\Models\Traits\HasTokenablePropertiesMethods as HasTokenablePropertiesMethodsTrait;
// rocXolid admin controllers
use Softworx\RocXolid\Admin\Auth\Controllers\ProfileController;
// rocXolid admin events
use Softworx\RocXolid\Admin\Auth\Events\UserForgotPassword;
// rocXolid common model traits
use Softworx\RocXolid\Common\Models\Traits\HasAddresses;
use Softworx\RocXolid\Common\Models\Traits\HasImage;
// rocXolid user management model traits
use Softworx\RocXolid\UserManagement\Models\Traits\HasRoles;
use Softworx\RocXolid\UserManagement\Models\Traits\HasGroups;
use Softworx\RocXolid\UserManagement\Models\Traits\HasPermissions;
use Softworx\RocXolid\UserManagement\Models\Traits\HasUserProfile;
use Softworx\RocXolid\UserManagement\Models\Traits\HasCompanyProfile;
use Softworx\RocXolid\UserManagement\Models\Traits\ProtectsRoot;

/**
 * rocXolid user class.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Admin
 * @version 1.0.0
 */
class User extends Authenticatable implements Crudable, HasTokenablePropertiesMethods
{
    use Notifiable;
    use CrudableTrait;
    use HasTitleColumn;
    use HasRoles;
    use HasGroups;
    use HasPermissions;
    use HasUserProfile;
    use HasCompanyProfile;
    use HasAddresses;
    use HasImage;
    use ProtectsRoot;
    use HasTokenablePropertiesMethodsTrait;

    const ROOT_ID = 1;

    /**
     * Flag if model instances can be user deleted.
     *
     * @var boolean
     */
    protected static $can_be_deleted = true;

    protected static $title_column = 'name';

    protected static $tokenable_properties = [
        'name',
        'email',
        'created_at',
    ];

    protected static $tokenable_methods = [
        'resetPasswordUrl',
    ];

    protected $system = [
        'password',
        'email_verified_at',
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
        'password',
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

    public $password_reset_token;

    protected $extra = [];

    public function getTitle()
    {
        return sprintf('%s (%s)', $this->profile()->exists() ? $this->profile->getTitle() : null, $this->email);
    }

    public function getProfileControllerRoute($method = 'index', $params = []): string
    {
        $action = sprintf('\%s@%s', ProfileController::class, $method);

        return action($action, $params);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getLastAction()
    {
        return null;
    }

    public function getStatus($seconds = 3600)
    {
        return null;
    }

    public function getDaysFirstLogin()
    {
        return null;
    }

    /*
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
    */

    // @todo: hotfixed
    public function getAttributeViewValue($attribute)
    {
        return $this->$attribute;
    }

    public function applyGroupFilters(&$builder, $column)
    {
        if (!$this->isRoot()) {
            $webs = new Collection();

            $this->load(['groups.websNoneScope' => function ($query) use (&$webs) {
                $webs = $query->get()->unique();
            }]);

            $builder->whereIn($column, $webs->pluck('id'));
        }

        return $this;
    }

    public function isRoot()
    {
        return ($this->id === static::ROOT_ID);
    }

    // @todo: type hints
    protected function allowPermissionException($user, $method_group, $permission)
    {
        if (in_array($method_group, ['index', 'authorization'])) {
            return false;
        }

        return !$this->user || $this->user->is($user);
    }

    /**
     * {@inheritDoc}
     */
    public function notify($instance)
    {
        if ($instance instanceof ResetPassword) {
            $this->password_reset_token = $instance->token;

            event(new UserForgotPassword($this));
        } else {
            parent::notify($instance);
        }
    }

    public function resetPasswordUrl()
    {
        // ignore when used eg. in e-mail notification
        if (!$this->exists) {
            return null;
        }

        if (!isset($this->password_reset_token)) {
            throw new \UnderflowException(sprintf('No password reset token set for user [%s]', $this->email));
        }

        return route('rocXolid.auth.reset-password', [ 'token' => $this->password_reset_token ]);
    }
}
