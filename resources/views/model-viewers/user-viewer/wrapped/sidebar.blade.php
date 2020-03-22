<div id="{{ $component->getDomId('sidebar') }}" class="row">
    <div class="col-xs-12">
        <div class="col-md-5 col-xs-12 text-center">
            <div class="avatar img-circle">
                {!! $component->render('snippet.avatar', [ 'param' => 'sidebar' ]) !!}
            </div>
        </div>
        <div class="col-md-7 col-xs-12 profile-info padding-top-10">
            <span>{{ $wrapper->translate('sidebar.text.welcome') }}</span>
            <h2>{!! $component->render('snippet.name', [ 'param' => 'sidebar' ]) !!}</h2>
        </div>
    </div>
</div>