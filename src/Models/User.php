<?php

namespace Softworx\RocXolid\UserManagement\Models;

use Hash;
use Html;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable;
// rocXolid controller contracts
use Softworx\RocXolid\Http\Controllers\Contracts\Crudable as CrudableController;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\Models\Contracts\HasTokenablePropertiesMethods;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits\Crudable as CrudableTrait;
use Softworx\RocXolid\Models\Traits\HasTokenablePropertiesMethods as HasTokenablePropertiesMethodsTrait;
// rocXolid admin auth services
use Softworx\RocXolid\Admin\Auth\Services\UserActivityService;
// rocXolid admin auth data holders
use Softworx\RocXolid\Admin\Auth\DataHolders\AbstractUserActivity;
// rocXolid admin auth controllers
use Softworx\RocXolid\Admin\Auth\Http\Controllers\ProfileController;
// rocXolid admin auth events
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
 * @package Softworx\RocXolid\UserManagement
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
     * Check if user is Root.
     *
     * @return bool
     */
    public function isRoot(): bool
    {
        return ($this->getKey() === static::ROOT_ID);
    }

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
    public function getTitle(): string
    {
        return $this->profile()->exists() ? $this->profile->getTitle() : $this->name;
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
     * Get last user's activity.
     *
     * @return \Softworx\RocXolid\Admin\Auth\DataHolders\AbstractUserActivity|null
     */
    public function getLastActivity(): ?AbstractUserActivity
    {
        return app(UserActivityService::class)->getUserActivity($this);
    }

    /**
     * Check if user is currently online.
     *
     * @return bool
     */
    public function isOnline(): bool
    {
        return app(UserActivityService::class)->isOnline($this);
    }

    /**
     * Image upload handler.
     *
     * @param \Softworx\RocXolid\Common\Models\Image $image Uploaded image reference.
     * @param \Softworx\RocXolid\Http\Controllers\Contracts\Crudable $controller Active controller reference.
     * @return \Softworx\RocXolid\UserManagement\Models\User
     */
    public function onImageUpload(Image $image, CrudableController $controller): User
    {
        if (auth('rocXolid')->user()->is($this)) {
            $user_model_viewer = $this->getModelViewerComponent();

            $controller->getResponse()->replace(
                $user_model_viewer->getDomId('avatar', 'sidebar'),
                $user_model_viewer->fetch('snippet.avatar', [ 'param' => 'sidebar' ])
            );

            $controller->getResponse()->replace('topbar-profile-image', Html::image(
                $image->getControllerRoute('get', [ 'size' => 'thumb-square' ]),
                $image->name,
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

    /**
     * {@inheritDoc}
     */
    public function canBeDeleted(Request $request): bool
    {
        return !$this->isRoot();
    }
}
