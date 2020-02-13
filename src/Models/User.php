<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Hash;
use Html;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable;
// rocXolid utils
use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\Models\Contracts\HasTokenablePropertiesMethods;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits\Crudable as CrudableTrait;
use Softworx\RocXolid\Models\Traits\HasTokenablePropertiesMethods as HasTokenablePropertiesMethodsTrait;
// rocXolid admin controllers
use Softworx\RocXolid\Admin\Auth\Controllers\ProfileController;
// rocXolid admin events
use Softworx\RocXolid\Admin\Auth\Events\UserForgotPassword;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Image;
// rocXolid common model traits
use Softworx\RocXolid\Common\Models\Traits\HasAddress;
use Softworx\RocXolid\Common\Models\Traits\HasImage;
// rocXolid user management model contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization;
use Softworx\RocXolid\UserManagement\Models\Contracts\HasGroups;
// rocXolid user management model traits
use Softworx\RocXolid\UserManagement\Models\Traits\HasAuthorization as HasAuthorizationTrait;
use Softworx\RocXolid\UserManagement\Models\Traits\HasGroups as HasGroupsTrait;
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
class User extends Authenticatable implements
    Crudable,
    HasAuthorization,
    HasGroups,
    HasTokenablePropertiesMethods
{
    use ProtectsRoot;
    use Notifiable;
    use CrudableTrait;
    use HasAuthorizationTrait;
    use HasGroupsTrait;
    use HasUserProfile;
    use HasCompanyProfile;
    use HasAddress;
    use HasImage;
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

    /**
     * Get route for profile controller.
     *
     * @param string $method Controller method.
     * @param array $params Additional route parameters.
     * @return string
     */
    public function getProfileControllerRoute($method = 'index', $params = []): string
    {
        $action = sprintf('\%s@%s', ProfileController::class, $method);

        return action($action, $params);
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {
        return sprintf('%s (%s)', $this->profile()->exists() ? $this->profile->getTitle() : $this->name, $this->email);
    }

    /**
     * {@inheritDoc}
     */
    public function isOwnership(Authorizable $user): bool
    {
        return $this->is($user);
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

    /**
     * Hash password before storing.
     *
     * @param string $password Unhashed password.
     * @return \Softworx\RocXolid\UserManagement\Models\User
     */
    public function setPasswordAttribute(string $password): User
    {
        $this->attributes['password'] = Hash::make($password);

        return $this;
    }

    /**
     * Get last user's action time.
     *
     * @return string
     */
    public function getLastAction(): string
    {
        // return Carbon::parse($this->last_action)->format('j.n.Y H:i:s');
        return '';
    }

    /**
     * Get user's online status.
     *
     * @return string
     */
    public function getStatus($seconds = 3600): string
    {
        // @todo: check against session timeout in app configuration
        /*
        $logged = is_null($this->logged_out) && Carbon::parse($this->last_action)->gt(Carbon::now()->subSeconds($seconds));

        return (new Message())->fetch(sprintf('status.%s', $logged ? 'on' : 'off'));
        */
        return '';
    }

    /**
     * Get the time user first logged in for current day.
     *
     * @return string
     */
    public function getDaysFirstLogin(): string
    {
        /*
        if (!is_null($this->days_first_login) && Carbon::parse($this->days_first_login)->isToday())
        {
            return Carbon::parse($this->days_first_login)->format('H:i');
        }
        else
        {
            return __('rocXolid::user.text.not-yet');
        }
        */
        return '';
    }

    // @todo: hotfixed, you can do better
    public function getAttributeViewValue(string $attribute)
    {
        return $this->$attribute;
    }

    // @todo: kinda hotfixed, would be better with permission constraints (can (un)assign specific role)
    public function fillRoles(array $data): Crudable
    {
        // updating self
        if (array_key_exists('roles', $data)
            && ($user = auth('rocXolid')->user())
            && $user->is($this)) {

            $roles = collect($data['roles'])
                ->diff($this->getSelfNonAssignableRoles()->pluck('id'))
                ->merge($this->roles->where('is_self_unassignable', 0)->pluck('id'));

            $this->roles()->sync($roles);

            return $this;
        } else {
            return $this->fillBelongsToMany('roles', $data);
        }
    }

    /**
     * Apply scope for objects according to assigned groups.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $column
     * @return \Softworx\RocXolid\UserManagement\Models\User
     */
    public function applyGroupFilters(Builder &$builder, string $column): User
    {
        if (!$this->isRoot()) {
            $webs = collect();

            $this->load(['groups.websNoneScope' => function ($query) use (&$webs) {
                $webs = $query->get()->unique();
            }]);

            $builder->whereIn($column, $webs->pluck('id'));
        }

        return $this;
    }

    /**
     * Check if user is Root.
     *
     * @return bool
     */
    public function isRoot(): bool
    {
        return ($this->getKey() === static::ROOT_ID);
    }

    /**
     * Generate password reset URL.
     *
     * @return string|null
     * @throws \UnderflowException If no password reset token assigned.
     */
    public function resetPasswordUrl(): ?string
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

    /**
     * Image upload handler.
     *
     * @param \Softworx\RocXolid\Common\Models\Image $image Uploaded image reference.
     * @param \Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse $response Response reference.
     * @return \Softworx\RocXolid\UserManagement\Models\User
     * @todo: events?
     */
    public function onImageUpload(Image $image, AjaxResponse &$response): User
    {
        if (auth('rocXolid')->user()->is($this)) {
            $response->replace('sidebar-profile-image', Html::image(
                $this->image->getControllerRoute('get', [ 'size' => 'thumb-square' ]),
                $this->name,
                [ 'id' => 'sidebar-profile-image', 'class' => 'img-circle profile_img' ])
            );

            $response->replace('topbar-profile-image', Html::image(
                $this->image->getControllerRoute('get', [ 'size' => 'thumb-square' ]),
                $this->name,
                [ 'id' => 'topbar-profile-image' ])
            );
        }

        return $this;
    }

    /**
     * Retrieve path to redirect user after image has been deleted.
     *
     * @return string
     */
    public function deleteImageRedirectPath(): string
    {
        return auth('rocXolid')->user()->is($this)
            ? route('rocXolid.auth.profile')
            : $this->getControllerRoute('show');
    }
}
