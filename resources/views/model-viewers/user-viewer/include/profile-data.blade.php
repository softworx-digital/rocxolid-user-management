<div id="{{ $component->getDomId('profile-data') }}">
@if ($component->getModel()->profile()->exists())
    <h2>
        {{ $component->translate('text.profile-data') }}
    @if ($component->getModel()->userCan('write'))
        <a data-ajax-url="{{ $component->getModel()->profile->getControllerRoute('edit', ['_section' => 'profile-data']) }}" class="margin-left-5"><i class="fa fa-pencil"></i></a>
    @endif
    </h2>
    <div>
        {!! $component->getModel()->profile->getModelViewerComponent()->render('include.data') !!}
    </div>
@else
    <h2>
        {{ $component->translate('text.profile-data') }}
    @if ($component->getModel()->userCan('write'))
        <a data-ajax-url="{{ $component->getModel()->buildUserProfile()->getControllerRoute('create', ['_section' => 'profile-data', '_data[user_id]' => $component->getModel()->id]) }}" class="margin-left-5"><i class="fa fa-pencil"></i></a>
    @endif
    </h2>
    <p><i class="fa fa-info-circle text-warning fa-2x text-vertical-align-middle margin-right-5"></i> {{ $component->translate('text.profile-data-unavailable') }}</p>
@endif
</div>