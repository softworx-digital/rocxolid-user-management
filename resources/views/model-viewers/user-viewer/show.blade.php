<div id="{{ $component->getDomId('show', $component->getModel()->getKey()) }}" class="x_panel ajax-overlay">
    <div class="x_content">
        {!! $component->render('include.header-panel') !!}

        <div class="row">
            <div class="col-xl-3 col-md-4 col-xs-12 margin-top-10">
            {{-- @todo ugly --}}
            @can('update', [ $component->getModel(), 'image' ])
                {!! $component->render('include.image-upload', [ 'attribute' => 'image', 'relation' => 'parent', 'related' => $component->getModel() ]) !!}
            @endcan
            </div>
            <div class="col-xl-5 col-md-4 col-xs-12">
                <div class="row">
                    <div class="col-xs-12">
                    @if ($component->getModel()->profile()->exists())
                        {!! $component->getModel()->profile->getModelViewerComponent()->render('related.show', [ 'attribute' => 'profile', 'relation' => 'user' ]) !!}
                    @else
                        {!! $component->getModel()->profile()->make()->getModelViewerComponent()->render('related.unavailable', [ 'attribute' => 'profile', 'relation' => 'user', 'related' => $component->getModel() ]) !!}
                    @endif
                    </div>
                    <div class="col-xs-12">
                    @if ($component->getModel()->company()->exists())
                        {!! $component->getModel()->company->getModelViewerComponent()->render('related.show', [ 'attribute' => 'company', 'relation' => 'user' ]) !!}
                    @else
                        {!! $component->getModel()->company()->make()->getModelViewerComponent()->render('related.unavailable', [ 'attribute' => 'company', 'relation' => 'user', 'related' => $component->getModel() ]) !!}
                    @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 col-xs-12">
                <div class="row">
                    <div class="col-xs-12">
                    @if ($component->getModel()->address()->exists())
                        {!! $component->getModel()->address->getModelViewerComponent()->render('related.show', [ 'attribute' => 'address', 'relation' => 'parent' ]) !!}
                    @else
                        {!! $component->getModel()->address()->make()->getModelViewerComponent()->render('related.unavailable', [ 'attribute' => 'address', 'relation' => 'parent', 'related' => $component->getModel() ]) !!}
                    @endif
                    </div>
                    <div class="col-xs-12">
                        {!! $component->render('include.authentication-data') !!}
                    </div>
                    <div class="col-xs-12">
                        {!! $component->render('include.authorization-data') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="x_footer">
    @can ('backAny', $component->getModel())
        <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back') }}</a>
    @endcan
        {{-- @todo: button na delete a ine akcie --}}
    </div>
</div>