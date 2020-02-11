<div id="{{ $component->getDomId('header-panel') }}" class="x_title">
@if ($component->getModel()->exists)
    <h1>
        <i class="fa fa-id-card-o margin-right-5"></i>
    @if ($component->getModel()->profile()->exists() && $component->getModel()->profile->getTitle())
        <span class="text-big">{!! $component->getModel()->profile->getTitle() !!}</span>
    @elseif ($component->getModel()->getTitle())
        <span class="text-big">{!! $component->getModel()->getTitle() !!}</span>
    @endif
        <small class="pull-right margin-top-20 hidden-xs"><i class="fa fa-star margin-right-10" title="{{ $component->translate('field.created_at') }}"></i>{{ \Carbon\Carbon::parse($component->getModel()->created_at)->format('j.n.Y H:i:s') }}</small>
    </h1>
@else
    <h2>
        <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small>
        <span class="model-class-title">{{ $component->translate('model.title.singular') }}</span>
    </h2>
@endif
</div>