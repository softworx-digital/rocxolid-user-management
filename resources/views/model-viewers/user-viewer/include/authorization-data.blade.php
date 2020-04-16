@if ($user->can('assign', [ $component->getModel(), 'groups' ]) || $user->can('assign', [ $component->getModel(), 'roles' ]) || $user->can('assign', [ $component->getModel(), 'permissions' ]))
<div id="{{ $component->getDomId('authorization-data') }}" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->translate('text.authorization-data') }}
        @can ('update', $component->getModel())
            <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'authorization-data']) }}" class="margin-left-5 pull-right" title="{{ $component->translate('button.edit') }}"><i class="fa fa-pencil"></i></a>
        @endcan
        </h3>
    </div>
    <div class="panel-body">
        <dl class="dl-horizontal">
        @foreach ($component->getModel()->getRelationshipMethods() as $attribute)
            @can ('assign', [ $component->getModel(), $attribute ])
                <dt>{{ $component->translate(sprintf('field.%s', $attribute)) }}</dt>
                <dd>
                @foreach ($component->getModel()->$attribute()->get() as $item)
                    @can ('update', $item)
                        <a class="label label-info" data-ajax-url="{{ $item->getControllerRoute() }}">{{ $item->getTitle() }}</a>
                    @elsecan('view', $item)
                        <span class="label label-info">{{ $item->getTitle() }}</span>
                    @endcan
                @endforeach
                </dd>
            @endcan
        @endforeach
        </dl>
    </div>
</div>
@endif