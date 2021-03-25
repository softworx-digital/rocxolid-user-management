<div id="{{ $component->getDomId('show', $component->getModel()->getKey()) }}" class="x_panel ajax-overlay">
    <div class="x_content">
        {!! $component->render('include.header-panel') !!}
    @if ($component->getModel()->getPreferencesType())
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading padding-bottom-0">
                {!! $component->render('include.nav', [ 'tab' => $tab ]) !!}
            </div>
            <div class="panel-body">
                {!! $component->render(sprintf('tab.%s', $tab ?? 'default')) !!}
            </div>
        </div>
    @else
        <div class="col-xs-12">
            {!! $component->render('tab.default') !!}
        </div>
    @endif
    </div>

    {!! $component->render('include.footer-panel') !!}
</div>