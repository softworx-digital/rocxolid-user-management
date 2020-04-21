<div id="{{ $component->getDomId('header-panel') }}" class="x_title">
    <div class="row">
    @if ($component->getModel()->exists)
        <div class="col-md-8 col-xs-12">
            <h1 class="text-overflow">
                <i class="fa fa-id-card-o margin-right-5"></i>
            @if ($component->getModel()->profile()->exists() && $component->getModel()->profile->getTitle())
                <span class="text-big">{{ $component->getModel()->profile->getTitle() }}</span>
            @elseif ($component->getModel()->getTitle())
                <span class="text-big">{{ $component->getModel()->getTitle() }}</span>
            @endif
                <small><a href="mailto:{{ $component->getModel()->email }}">{{ $component->getModel()->getAttributeViewValue('email') }}</a></small>
            </h1>
        </div>
        <div class="col-md-4 col-xs-12 text-right hidden-sm">
            <h4><i class="fa fa-star margin-right-10" title="{{ $component->translate('field.created_at') }}"></i>{{ $component->getModel()->getAttributeViewValue('created_at') }}</h4>
        </div>
    @else
        <div class="col-xs-12">
            <h2 class="text-overflow">
                <small class="pull-left">{{ $component->translate(sprintf('action.%s', $route_method)) }}</small>
                <span class="model-class-title">{{ $component->translate('model.title.singular') }}</span>
            </h2>
        </div>
    @endif
    </div>
</div>