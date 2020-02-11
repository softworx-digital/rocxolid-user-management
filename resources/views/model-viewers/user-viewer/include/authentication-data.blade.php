<div id="{{ $component->getDomId('authentication-data') }}" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->translate('text.authentication-data') }}
        @can('update', $component->getModel())
            <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'authentication-data']) }}" class="margin-left-5 pull-right" title="{{ $component->translate('button.edit') }}"><i class="fa fa-pencil"></i></a>
        @endcan
        </h3>
    </div>
    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>{{ $component->translate('field.email') }}</dt><dd>{{ $component->getModel()->email }}</dd>
            <dt>{{ $component->translate('field.password') }}</dt><dd><i class="fa fa-ellipsis-h"></i><i class="fa fa-ellipsis-h" style="margin-left: 1px;"></i></dd>
        </dl>
    </div>
</div>