<tr>
    <th class="col-md-2">
    @if (app($controller::getModelClass())->hasRelationshipMethods())
        <i class="fa fa-cogs" aria-hidden="true"></i>
    @endif
        <span>{{ app($controller)->translate('model.title.singular') }}</span>
    </th>
    <td>
        <button class="btn btn-default btn-sm" title="{{ app($controller)->translate(sprintf('permissions.full')) }}"><i class="fa fa-check"></i></button>
        <button class="btn btn-default btn-sm" title="{{ app($controller)->translate(sprintf('permissions.none')) }}"><i class="fa fa-times"></i></button>
    </td>
@foreach (PermissionLoader::sortByAbilities($permissions->where('policy_ability', '!=', 'full')) as $permission)
    <td>{!! $component->render('permissions-assignment.include.assignment', [ 'controller' => $controller,  'permission' => $permission ]) !!}</td>
@endforeach
</tr>
@foreach (app($controller::getModelClass())->getRelationshipMethods() as $method)


@endforeach