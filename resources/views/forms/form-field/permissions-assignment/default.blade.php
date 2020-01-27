<div class="panel panel-default">
    <div class="panel-heading">
    @if ($component->getOption('label', false) && !$component->getOption('label.after', false))
        <label {!! $component->getHtmlAttributes('label') !!}>
            {{ $component->translate($component->getOption('label.title')) }}
            @if ($component->getOption('label.hint', false))
                <i class="fa fa-question-circle text-warning" title="{{ $component->translate($component->getOption('label.hint')) }}"></i>
            @endif
        </label>
    @endif
    </div>
    <div class="panel-body padding-bottom-0">
    @foreach ($component->getFormField()->getCollection() as $package_key => $package_permissions)
        <div class="panel panel-primary">
            <div class="panel-heading" data-toggle="collapse" href="{{ $component->getDomIdHash(Str::slug($package_key)) }}" style="cursor: pointer;">
                <span>{{ ($package = Package::get($package_key)) ? $package::getTitle() : $component->translate($package_key, [], true) }}</span>
            </div>
            <div id="{{ $component->getDomId(Str::slug($package_key)) }}" class="panel-collapse collapse">
                <div class="panel-body panel-permissions">
                @foreach ($package_permissions->where('attribute', null)->groupBy('controller_class') as $controller => $permissions)
                    <div class="resource-permissions">
                    {!! $component->render('permissions-assignment.include.row', [
                        'controller' => app($controller),
                        'permissions' => $permissions,
                        'attributes' => $package_permissions->whereIn('model_class', $permissions->pluck('model_class'))->where('attribute', '!=', null),
                    ]) !!}
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>