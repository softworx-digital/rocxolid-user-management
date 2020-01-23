@foreach ($component->getFormField()->getCollection() as $package_key => $package_permissions)
<div class="panel panel-default">
    <div class="panel-heading">
        <a data-toggle="collapse" href="{{ $component->getDomIdHash(Str::slug($package_key)) }}">{{ ($package = Package::get($package_key)) ? $package::getTitle() : $component->translate($package_key, [], true) }}</a>
    </div>
    <div id="{{ $component->getDomId(Str::slug($package_key)) }}" class="panel-collapse collapse">
        <div class="panel-body">
            <table class="table table-permissions">
                <tbody>
                @foreach ($package_permissions->groupBy('controller_class') as $controller => $permissions)
                    {!! $component->render('permissions-assignment.include.row', [ 'controller' => $controller,  'permissions' => $permissions ]) !!}
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endforeach