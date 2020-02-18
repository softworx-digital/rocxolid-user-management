{{-- @todo: "hotfixed" --}}
@if ($permission->policy_ability === 'viewAny')
<i class="fa fa-list" title="{{ $controller->translate(sprintf('permissions.%s', $permission->policy_ability)) }}"></i>
@elseif ($permission->policy_ability === 'view')
<i class="fa fa-eye" title="{{ $controller->translate(sprintf('permissions.%s', $permission->policy_ability)) }}"></i>
@elseif ($permission->policy_ability === 'create')
<i class="fa fa-star" title="{{ $controller->translate(sprintf('permissions.%s', $permission->policy_ability)) }}"></i>
@elseif ($permission->policy_ability === 'update')
<i class="fa fa-edit" title="{{ $controller->translate(sprintf('permissions.%s', $permission->policy_ability)) }}"></i>
@elseif ($permission->policy_ability === 'delete')
<i class="fa fa-trash" title="{{ $controller->translate(sprintf('permissions.%s', $permission->policy_ability)) }}"></i>
@elseif ($permission->policy_ability === 'assign')
<i class="fa fa-external-link" title="{{ $controller->translate(sprintf('permissions.%s', $permission->policy_ability)) }}"></i>
@else
<small>{{ $controller->translate(sprintf('permissions.%s', $permission->policy_ability)) }}</small>
@endif

<div class="resource-permissions-policy-ability d-inline-block">
    <div class="btn-group btn-group-xs margin-left-5" data-toggle="buttons" style="min-height: 22px;">
        <label
            class="btn text-wrap btn-default btn-active-success @if ($component->getFormField()->isFieldValue($permission->getKey())) active @endif"
            data-click-check=":radio[value='policy.scope.all']"
            data-click-check-container=".resource-permissions-policy-ability"
            data-click-enable="> .resource-permissions-policy-ability-scopes :radio"
            data-click-enable-container=".resource-permissions-policy-ability">
            {!! Form::radio($component->getFormField()->getPermissionFieldName($permission), 1, $component->getFormField()->isFieldValue($permission->getKey())) !!}
            <i class="fa fa-check"></i>
        </label>
        <label
            class="btn text-wrap btn-default btn-active-danger @if (!$component->getFormField()->isFieldValue($permission->getKey())) active @endif"
            data-click-uncheck=":radio"
            data-click-uncheck-container=".resource-permissions-policy-ability"
            data-click-disable="> .resource-permissions-policy-ability-scopes :radio"
            data-click-disable-container=".resource-permissions-policy-ability">
            {!! Form::radio($component->getFormField()->getPermissionFieldName($permission), 0, !$component->getFormField()->isFieldValue($permission->getKey())) !!}
            <i class="fa fa-times"></i>
        </label>
    </div>
@if ($permission->hasScopes())
    <div class="btn-group btn-group-xs resource-permissions-policy-ability-scopes" data-toggle="buttons" style="min-height: 22px;">
    @foreach ($permission->getScopes() as $binding)
        @if (!$component->getFormField()->isFieldValue($permission->getKey()))
        <label
            class="btn text-wrap btn-default disabled"
            title="{{ $controller->translate(sprintf('permissions-scope.%s', $binding)) }}">
            {!! Form::radio($component->getFormField()->getPermissionPivotFieldName($permission, 'scope_type'), $binding, false, [ 'disabled' => 'disabled' ]) !!}
            <i class="fa fa-{{ app($binding)->icon }}"></i>
        </label>
        @else
        <label
            class="btn text-wrap btn-default @if ($component->getFormField()->isModelPivotAttributeValue($permission, 'scope_type', $binding)) active @endif "
            title="{{ $controller->translate(sprintf('permissions-scope.%s', $binding)) }}">
            {!! Form::radio($component->getFormField()->getPermissionPivotFieldName($permission, 'scope_type'), $binding, $component->getFormField()->isModelPivotAttributeValue($permission, 'scope_type', $binding)) !!}
            <i class="fa fa-{{ app($binding)->icon }}"></i>
        </label>
        @endif
    @endforeach
    </div>
@endif
</div>