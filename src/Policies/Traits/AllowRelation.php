<?php

namespace Softworx\RocXolid\UserManagement\Policies\Traits;

use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// rocXolid services
use Softworx\RocXolid\Services\CrudRouterService;
// rocXolid form contracts
use Softworx\RocXolid\Forms\Contracts\FormField;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;

/**
 * Enables to check the relation permission for a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\UserManagement
 * @version 1.0.0
 */
trait AllowRelation
{
    /**
     * Allow root access for all abilities.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $ability
     * @return bool|void
     */
    public function checkAllowRelation(Authorizable $user, string $ability): ?bool
    {
        switch ($ability) {
            case 'create':
            case 'update':
            case 'delete':
                return $this->checkRelationPermission($user, $ability);
        }

        return null;
    }

    /**
     * Check if user is allowed to do some ability with model that is related, eg. image of an article.
     * The method first retrieves the model class based on called controller.
     * The method first retrieves the 'abilitied' model's RELATED MODEL according to model_attribute and relation, if provided.
     * Then the RELATED MODEL is queried if user can do the ability with the model, which is the RELATED MODEL's attribute.
     *
     * @param \Illuminate\Contracts\Auth\Access\Authorizable $user
     * @param string $ability
     * @return bool|null
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    private function checkRelationPermission(Authorizable $user, string $ability): ?bool
    {
        $input = collect($this->request->input());

        /*

        (child) model ------- relation ------> related (parent)
                      <--- model_attribute --- related

        or
            model x relation = related
            model = related x attribute

        */

        if ($input->has(FormField::SINGLE_DATA_PARAM)) {
            $input = collect($input->get(FormField::SINGLE_DATA_PARAM));

            // model_attribute is the name of the related relation to the model that is being 'abilitied'
            if ($input->has('model_attribute')) {
                $attribute = $input->get('model_attribute');

                if (!$input->has('relation') || blank($input->get('relation'))) {
                    throw new \InvalidArgumentException(sprintf('Undefined [%s] param in request', 'relation'));
                }

                $model_class = $model_class ?? $this->controller->getModelType();
                $model = collect($this->request->route()->parameters())->first() ?? app($model_class);
                $relation_name = $input->get('relation');
                $relation = $model->{$relation_name}();
                $relation_permission_check_method = sprintf('check%sRelationPermission', Str::studly($relation_name));

                if (method_exists($this, $relation_permission_check_method)) {
                    $this->log(sprintf('Delegating permission checking request relation to [%s()]', $relation_permission_check_method));

                    return $this->$relation_permission_check_method($user, $ability);
                } elseif ($relation instanceof MorphTo) {
                    if ($type = $model->resolvePolymorphType($input->only([
                        $relation->getMorphType(),
                        $relation->getForeignKeyName(),
                    ]))) {
                        $related = $model->exists ? $model->$relation_name : app($type);
                    } else {
                        $this->log(sprintf('Checking request relation: [%s] <--- %s - %s ---> [%s]: -', $model_class, $relation_name, $attribute, get_class($relation->getRelated())));

                        return false;
                    }
                } elseif ($relation instanceof MorphToMany) {
                    dd(__METHOD__, 'TODO');
                } elseif ($relation instanceof BelongsTo) {
                    $related = $model->exists ? $model->$relation_name : $relation->getRelated();
                } else {
                    return true; // @todo hotfixed
                    throw new \RuntimeException(sprintf(
                        'Unsupported relation type [%s] for [%s->%s()]',
                        get_class($relation),
                        $model_class,
                        $input->get('relation'),
                    ));
                }

                $this->log(sprintf('>> Checking relation identified from request: [%s] <--- %s - %s ---> [%s]', $model_class, $relation_name, $attribute, get_class($relation->getRelated())));

                $allowed = !is_null($related) && $this->checkAttributePermissions($user, $ability, $related, $attribute);

                $this->log(sprintf('<< Relation %s - %s: %s', $relation_name, $attribute, ($allowed ? '✅' : '❌')));

                return $allowed;
            }
        }

        return null;
    }
}
