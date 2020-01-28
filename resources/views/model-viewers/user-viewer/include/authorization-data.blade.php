todo data.blade
<div id="{{ $component->getDomId('authorization-data') }}">
    <h2>
        {{ $component->translate('text.authorization-data') }}
    todo data.blade
        <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'authorization-data']) }}" class="margin-left-5"><i class="fa fa-pencil"></i></a>

    </h2>
    <div>
        <dl class="dl-horizontal">
        @foreach ($component->getModel()->getRelationshipMethods() as $method)
            <dt>{{ $component->translate(sprintf('field.%s', $method)) }}</dt>
            <dd>
            @foreach ($component->getModel()->$method()->get() as $item)
            todo data.blade
                    <a class="label label-info" data-ajax-url="{{ $item->getControllerRoute() }}">{{ $item->getTitle() }}</a>

                    <span class="label label-info">{{ $item->getTitle() }}</span>
            @endforeach
            </dd>
        @endforeach
        </dl>
    </div>
</div>