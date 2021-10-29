@can ('viewAny', $component->getModel())
<div id="{{ $component->getDomId(sprintf('panel.%s', $param)) }}" class="panel panel-{{ $class ?? 'default' }}">
    <div class="panel-heading">
        <h3 class="panel-title">
            <i class="fa fa-signal margin-right-5"></i>
            {{ $component->translate(sprintf('panel.%s.heading', $param)) }}
        </h3>
    </div>
@if ($component->getModel()->getLastActivity())
    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>{{ $component->translate(sprintf('panel.%s.status.heading', $param)) }}</dt>
        @if ($component->getModel()->isOnline())
            <dd class="text-success"><i class="fa fa-check-circle margin-right-5"></i>{{ $component->translate(sprintf('panel.%s.status.online', $param)) }}</dd>
        @else
            <dd><i class="fa fa-circle margin-right-5"></i>{{ $component->translate(sprintf('panel.%s.status.offline', $param)) }}</dd>
        @endif
            <dt>{{ $component->translate(sprintf('panel.%s.time', $param)) }}</dt><dd>{{ $component->getModel()->getLastActivity()->getTime() }}</dd>
            <dt>{{ $component->translate(sprintf('panel.%s.ip', $param)) }}</dt><dd>{{ $component->getModel()->getLastActivity()->getIp() }}</dd>
        @if (false)
            <dt>{{ $component->translate(sprintf('panel.%s.url', $param)) }}</dt><dd>{{ $component->getModel()->getLastActivity()->getUrl() }}</dd>
        @endif
        </dl>
    </div>
@else
    <div class="panel-body text-center text-primary">
        <i class="fa fa-info-circle fa-2x text-vertical-align-middle margin-right-5"></i> {{ $component->translate('text.unavailable') }}
    </div>
@endif
</div>
@endcan