<div id="{{ $component->getDomId('authentication-data') }}">
    <h2>
        {{ $component->translate('text.authentication-data') }}
    todo data.blade
        <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'authentication-data']) }}" class="margin-left-5"><i class="fa fa-pencil"></i></a>

    </h2>
    <div>
        <dl class="dl-horizontal">
            <dt>{{ $component->translate('field.email') }}</dt><dd>{{ $component->getModel()->email }}</dd>
            <dt>{{ $component->translate('field.password') }}</dt><dd><i class="fa fa-ellipsis-h"></i><i class="fa fa-ellipsis-h" style="margin-left: 1px;"></i></dd>
        </dl>
    </div>
</div>