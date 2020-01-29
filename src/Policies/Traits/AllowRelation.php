<?php

namespace Softworx\RocXolid\UserManagement\Policies\Traits;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    private function checkRelationPermission(Authorizable $user, string $ability)
    {
        $input = collect($this->request->input());

        if ($input->has(FormField::SINGLE_DATA_PARAM)) {
            $input = collect($input->get(FormField::SINGLE_DATA_PARAM));

            if ($input->has('model_attribute')) {
                $attribute = $input->get('model_attribute');

                if (!$input->has('relation') || blank($input->get('relation'))) {
                    throw new \InvalidArgumentException(sprintf('Undefined [%s] param in request', 'relation'));
                }

                $model_class = $model_class ?? $this->controller->getModelClass();
                $model = app($model_class);
                $relation = $model->{$input->get('relation')}();

                if ($relation instanceof MorphTo) {
                    $related = app($model->resolvePolymorphType($input->only([
                        $relation->getMorphType(),
                        $relation->getForeignKeyName(),
                    ])));
                } elseif ($relation instanceof MorphToMany) {
dd(__METHOD__, 'TODO');
                } elseif ($relation instanceof BelongsTo) {
                    $related = $relation->getRelated();
                } else {
                    throw new \RuntimeException(sprintf(
                        'Unsupported relation type [%s] for [%s->%s()]',
                        get_class($relation),
                        $model_class,
                        $input->get('relation'),
                    ));
                }

                return $this->checkAttributePermissions($user, $ability, $related, $attribute);
            }
        }

        return null;
    }
}