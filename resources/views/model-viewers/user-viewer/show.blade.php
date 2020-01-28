<div id="{{ $component->getDomId('show', $component->getModel()->id) }}" class="x_panel ajax-overlay">
    <div class="x_content">
        {!! $component->render('include.header-panel') !!}

        <div class="row">
            <div class="col-xl-2 col-md-4 col-xs-12 margin-top-10">
                {!! $component->render('include.image-upload') !!}
            </div>
            <div class="col-xl-4 col-xl-offset-1 col-md-4 col-xs-12">
                <div class="row col-xs-12">
                @if ($component->getModel()->profile()->exists())
                    {!! $component->getModel()->profile->getModelViewerComponent()->render() !!}
                @else
                    {!! $component->getModel()->makeUserProfile()->getModelViewerComponent()->render('unavailable', [ 'model' => $component->getModel() ]) !!}
                @endif
                </div>
                <div class="row col-xs-12">
                @if ($component->getModel()->company()->exists())
                    {!! $component->getModel()->company->getModelViewerComponent()->render() !!}
                @else
                    {!! $component->getModel()->makeCompanyProfile()->getModelViewerComponent()->render('unavailable', [ 'model' => $component->getModel() ]) !!}
                @endif
                </div>
            </div>
            <div class="col-xl-4 col-xl-offset-1 col-md-4 col-xs-12">
                <div class="row col-xs-12">
                @if ($component->getModel()->address()->exists())
                    {!! $component->getModel()->address->getModelViewerComponent()->render() !!}
                @else
                    {!! $component->getModel()->address()->make()->getModelViewerComponent()->render('unavailable', [ 'model' => $component->getModel() ]) !!}
                @endif
                </div>
                <div class="row col-xs-12">
                    {!! $component->render('include.authentication-data') !!}
                </div>
            todo data.blade
                <div class="row col-xs-12">
                    {!! $component->render('include.authorization-data') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="x_footer">
    todo data.blade
        <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back') }}</a>

        {{-- @todo: button na delete a ine akcie --}}
    </div>
</div>