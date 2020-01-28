<div id="{{ $component->getDomId('address') }}">
    <h2>
        {{ $component->translate('text.address') }}
    todo data.blade
        <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'address']) }}" class="margin-left-5"><i class="fa fa-pencil"></i></a>

    </h2>
    <address>
        {!! $component->getModel()->getAddressLabel(true, true) !!}<br />
    </address>
    <span class="label label-info label-lg">{{ $component->translate(sprintf('choices.type.%s', $component->getModel()->type)) }}</span>
@if ($component->getModel()->company)
    <dl class="dl-horizontal margin-top-20">
        <dt>{{ $component->translate('field.company') }}</dt><dd>{{ $component->getModel()->company }}</dd>
        <dt>{{ $component->translate('field.company_registration_number') }}</dt><dd>{{ $component->getModel()->company_registration_number }}</dd>
        <dt>{{ $component->translate('field.tax_no') }}</dt><dd>{{ $component->getModel()->tax_no }}</dd>
        <dt>{{ $component->translate('field.vat_number') }}</dt><dd>{{ $component->getModel()->vat_number }}</dd>
    </dl>
@endif
    <dl class="dl-horizontal margin-top-20">
        <dt>{{ $component->translate('field.note') }}</dt><dd>@if ($component->getModel()->note)<pre class="text-muted well well-sm no-shadow" style="border: 2px solid red;">{{ $component->getModel()->note }}</pre>@else - @endif</dd>
    </dl>
</div>