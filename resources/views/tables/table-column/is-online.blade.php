@if ($component->getOption('model')->isOnline())
    <span class="text-success"><i class="fa fa-check-circle margin-right-5" aria-hidden="true"></i>{{ $component->translate('activity.status.online') }}</span>
@else
    <span class="text-muted"><i class="fa fa-times-circle margin-right-5" aria-hidden="true"></i>{{ $component->translate('activity.status.offline') }}</span>
@endif