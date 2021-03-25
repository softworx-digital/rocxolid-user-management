<ul class="nav nav-tabs nav-justified">
    <li role="presentation" @if (!isset($tab) || ($tab === 'default'))class="active"@endif><a href="{{ $component->getController()->getRoute('show', $component->getModel()) }}">{!! $component->translate('tab.home') !!}</a></li>
@if (false)
    <li role="presentation" @if (isset($tab) && ($tab === 'preferences'))class="active"@endif><a href="{{ $component->getController()->getRoute('show', $component->getModel(), [ 'tab' => 'preferences' ]) }}">{!! $component->translate('tab.preferences') !!}</a></li>
@endif
</ul>