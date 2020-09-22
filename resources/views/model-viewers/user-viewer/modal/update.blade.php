<div id="{{ $component->getDomId(sprintf('modal-%s', $component->getFormComponent()->getForm()->getParam())) }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} <small>{{ $component->translate('action.update') }}</small></h4>
            </div>

            {!! $component->getFormComponent()->render('modal.update') !!}
        </div>
    </div>
</div>