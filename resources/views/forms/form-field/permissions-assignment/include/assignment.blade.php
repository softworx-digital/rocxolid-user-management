<span>{{ app($controller)->translate(sprintf('permissions.%s', $permission->policy_ability)) }}</span>
<div class="btn-group btn-group-xs margin-left-5" data-toggle="buttons" style="min-height: 24px;">
    <label class="btn text-wrap btn-default btn-active-success @if ($component->getFormField()->isFieldValue($permission->id)) active @endif">
        {!! Form::radio($component->getFormField()->getPermissionFieldName($permission), 1, $component->getFormField()->isFieldValue($permission->id)) !!}
        <i class="fa fa-check"></i>
    </label>
    <label class="btn text-wrap btn-default btn-active-danger @if (!$component->getFormField()->isFieldValue($permission->id)) active @endif">
        {!! Form::radio($component->getFormField()->getPermissionFieldName($permission), 0, !$component->getFormField()->isFieldValue($permission->id)) !!}
        <i class="fa fa-times"></i>
    </label>
</div>
<div class="btn-group btn-group-xs" data-toggle="buttons" style="min-height: 24px;">
    <label class="btn text-wrap btn-default @if ($component->getFormField()->isFieldValue($permission->id)) active @endif" title="{{ app($controller)->translate(sprintf('permissions-scope.%s', 'all')) }}">
        {!! Form::radio($component->getFormField()->getPermissionFieldName($permission), 1, $component->getFormField()->isFieldValue($permission->id)) !!}
        <i class="fa fa-globe"></i>
    </label>
    <label class="btn text-wrap btn-default @if (!$component->getFormField()->isFieldValue($permission->id)) active @endif" title="{{ app($controller)->translate(sprintf('permissions-scope.%s', 'owned')) }}">
        {!! Form::radio($component->getFormField()->getPermissionFieldName($permission), 0, !$component->getFormField()->isFieldValue($permission->id)) !!}
        <i class="fa fa-id-badge"></i>
    </label>
</div>
