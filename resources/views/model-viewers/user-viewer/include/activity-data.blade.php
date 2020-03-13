@can('viewAny', $component->getModel())
<div id="{{ $component->getDomId('activity-data') }}" class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title text-center">{{ $component->translate('text.activity-data') }}</h3>
    </div>
@if ($component->getModel()->getLastActivity())
    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>{{ $component->translate('activity.status.heading') }}</dt>
        @if ($component->getModel()->isOnline())
            <dd class="text-success"><i class="fa fa-check-circle margin-right-5" aria-hidden="true"></i>{{ $component->translate('activity.status.online') }}</dd>
        @else
            <dd><i class="fa fa-circle margin-right-5" aria-hidden="true"></i>{{ $component->translate('activity.status.offline') }}</dd>
        @endif
            <dt>{{ $component->translate('activity.time') }}</dt><dd>{{ $component->getModel()->getLastActivity()->getTime() }}</dd>
            <dt>{{ $component->translate('activity.ip') }}</dt><dd>{{ $component->getModel()->getLastActivity()->getIp() }}</dd>
        @if (false)
            <dt>{{ $component->translate('activity.url') }}</dt><dd>{{ $component->getModel()->getLastActivity()->getUrl() }}</dd>
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