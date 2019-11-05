@if ($component->getModel()->userCan('authorize'))
<div id="{{ $component->getDomId('authorization-data') }}">
    <h2>
        {{ $component->translate('text.authorization-data') }}
    @if ($component->getModel()->userCan('write'))
        <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'authorization-data']) }}" class="margin-left-5"><i class="fa fa-pencil"></i></a>
    @endif
    </h2>
    <div>
        <dl class="dl-horizontal">
        @foreach ($component->getModel()->getRelationshipMethods() as $method)
            <dt>{{ $component->translate(sprintf('field.%s', $method)) }}</dt>
            <dd>
            @foreach ($component->getModel()->$method()->get() as $item)
                @if ($item->userCan('read-only'))
                    <a class="label label-info" data-ajax-url="{{ $item->getControllerRoute() }}">{{ $item->getTitle() }}</a>
                @else
                    <span class="label label-info">{{ $item->getTitle() }}</span>
                @endif
            @endforeach
            </dd>
        @endforeach
        </dl>
    </div>
</div>
@endif