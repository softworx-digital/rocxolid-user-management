<div class="row">
    <div class="col-md-3">
    @if (isset($attribute))
        <p class="text-right margin-0">{{ $controller->translate(sprintf('field.%s', $attribute)) }}</p>
    @else
        <p class="margin-0">
            {{ $controller->translate('model.title.singular') }}

        @if (isset($attributes) && $attributes->isNotEmpty())
            <a class="btn btn-default btn-xs pull-right margin-right-0 collapsed" data-toggle="collapse" href="{{ $component->getDomIdHash(Str::slug(get_class($controller))) }}">{{ $controller->translate('text.attributes') }} <span class="caret"></span></a>
        @endif
        </p>
    @endif
    </div>
    <div class="col-md-9">
        <div class="col-md-1">
            <div class="btn-group btn-group-xs" data-toggle="buttons" style="min-height: 22px;">
                <button class="btn btn-default" data-click-delegate=":radio[value=1]" data-click-delegate-container=".resource-permissions" title="{{ $controller->translate(sprintf('permissions.full')) }}"><i class="fa fa-check"></i></button>
                <button class="btn btn-default" data-click-delegate=":radio[value=0]" data-click-delegate-container=".resource-permissions" title="{{ $controller->translate(sprintf('permissions.none')) }}"><i class="fa fa-times"></i></button>
            </div>
        </div>
    @foreach (PermissionLoader::sortByAbilities($permissions->whereIn('policy_ability_group', [ 'read-only', 'write', 'model-relation' ])) as $permission)
        <div class="col-md-2">
            {!! $component->render('permissions-assignment.include.assignment', [ 'controller' => $controller,  'permission' => $permission ]) !!}
        </div>
    @endforeach
    @if ($permissions->whereNotIn('policy_ability_group', [ 'read-only', 'write', 'model-relation' ])->count())
        <div class="col-md-1">
            <div class="dropdown">
                <div class="btn-group btn-group-xs" data-toggle="buttons" style="min-height: 22px;">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                        {{ $controller->translate('text.more-permissions') }}
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="panel-body">
                        @foreach (PermissionLoader::sortByAbilities($permissions->whereNotIn('policy_ability_group', [ 'read-only', 'write', 'model-relation' ])) as $permission)
                            <div>{!! $component->render('permissions-assignment.include.assignment', [ 'controller' => $controller,  'permission' => $permission ]) !!}</div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
</div>

@if (isset($attributes) && $attributes->isNotEmpty())
<div id="{{ $component->getDomId(Str::slug(get_class($controller))) }}" class="panel-collapse collapse row">
    <div class="col-xs-12">
    @foreach ($attributes->groupBy('attribute') as $attribute => $permissions)
        <div class="resource-permissions">
        {!! $component->render('permissions-assignment.include.row', [
            'controller' => $controller,
            'permissions' => $permissions,
            'attribute' => $attribute
        ]) !!}
        </div>
    @endforeach
    </div>
</div>
@endif