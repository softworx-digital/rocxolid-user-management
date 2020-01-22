@foreach (PermissionLoader::get() as $package_key => $package_permissions)
<div class="panel panel-default">
    <div class="panel-heading">
        <a data-toggle="collapse" href="{{ $component->getDomIdHash(Str::slug($package_key)) }}">{{ ($package = Package::get($package_key)) ? $package::getTitle() : $component->translate($package_key, [], true) }}</a>
    </div>
    <div id="{{ $component->getDomId(Str::slug($package_key)) }}" class="panel-collapse collapse">
        <div class="panel-body">
            <table class="table table-permissions">
                <tbody>
                @foreach ($package_permissions->groupBy('controller_class') as $controller => $permissions)
                    <tr>
                        <th class="col-md-3">{{ app($controller)->translate('model.title.singular') }}</th>
                    @foreach (PermissionLoader::sortByAbilities($permissions) as $permission)
                        <td>
                            <span>{{ app($controller)->translate(sprintf('permissions.%s', $permission->policy_ability)) }}</span>
                            <div class="btn-group btn-group-xs margin-left-5" role="group" style="min-height: 24px;">
                                <button type="button" class="btn btn-default"><i class="fa fa-check"></i></button>
                                <button type="button" class="btn btn-default"><i class="fa fa-times"></i></button>
                            </div>
                        @if (false)
                            {!! Form::select('', [], '', []) !!}
                        @endif
                        </td>
                    @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endforeach