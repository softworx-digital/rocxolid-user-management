<div class="x_footer">
    <div class="col-lg-2 col-xs-4">
    @can ('viewAny', get_class($component->getModel()))
        <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back') }}</a>
    @endcan
    </div>
    {!! $component->render('include.actions') !!}
</div>