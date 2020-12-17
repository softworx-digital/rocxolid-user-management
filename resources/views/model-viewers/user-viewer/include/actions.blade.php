<div id="{{ $component->getDomId('actions') }}" class="col-lg-10 col-xs-8">
@canany([ 'update', 'delete' ], $component->getModel())
    <div class="btn-group btn-group-responsive pull-right hidden-xs">
    @can ('delete', $component->getModel())
        <button class="btn btn-danger" data-ajax-url="{{ $component->getModel()->getControllerRoute('destroyConfirm') }}"><i class="fa fa-trash margin-right-5"></i>{{ $component->translate('button.delete') }}</button>
    @endcan
    </div>

    <div class="btn-group pull-right visible-xs-block dropup">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $component->translate('button.actions') }} <span class="caret"></span></button>
        <ul class="dropdown-menu">
        @can ('delete', $component->getModel())
            <li><a data-ajax-url="{{ $component->getModel()->getControllerRoute('destroyConfirm') }}"><i class="fa fa-trash margin-right-5"></i>{{ $component->translate('button.delete') }}</a></li>
        @endcan
        <ul>
    </div>
@endcan
</div>