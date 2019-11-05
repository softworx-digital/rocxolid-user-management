<div class="x_title">
    <h1>
        <i class="fa fa-id-card-o margin-right-5"></i>
    @if ($component->getModel()->profile()->exists() && $component->getModel()->profile->getTitle())
        <span class="text-big">{!! $component->getModel()->profile->getTitle() !!}</span>
    @elseif ($component->getModel()->getTitle())
        <span class="text-big">{!! $component->getModel()->getTitle() !!}</span>
    @endif
        <small class="pull-right margin-top-20"><i class="fa fa-star margin-right-10" title="{{ $component->translate('field.created_at') }}"></i>{{ \Carbon\Carbon::parse($component->getModel()->created_at)->format('j.n.Y H:i:s') }}</small>
    </h1>
    <div id="{{ $component->getDomId('output-icon') }}" class="pull-right"></div>
    <div class="clearfix"></div>
</div>