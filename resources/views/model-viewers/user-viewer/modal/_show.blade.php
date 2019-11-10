<div id="{{ $component->getDomId('show', $component->getModel()->id) }}" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small></h4>
            </div>

            <div class="modal-body">
                <section class="content invoice">
                    <div class="row">
                        <div class="col-xs-12 invoice-header">
                            <h1>
                                <i class="fa fa-id-card-o"></i> {{ $component->getModel()->title }} {{ $component->getModel()->name }} {{ $component->getModel()->surname }}
                            @if ($component->getModel()->is_blacklisted)
                                <i class="fa fa-exclamation-triangle text-danger" title="{{ $component->translate('text.is_blacklisted') }}"></i>
                            @endif
                                <small class="pull-right">{{ $component->translate('column.created_at') }}: {{ \Carbon\Carbon::parse($component->getModel()->created_at)->format('j.n.Y H:i:s') }}</small>
                            </h1>
                        </div>
                    </div>
                </section>

                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        {!! $component->render('include.address', [ 'ro' => true ]) !!}
                    </div>
                    <div class="col-sm-4 invoice-col">
                        {!! $component->render('include.contact', [ 'ro' => true ]) !!}
                    </div>
                    <div class="col-sm-4 invoice-col">
                        {!! $component->render('include.premium-account', [ 'ro' => true ]) !!}
                    </div>
                </div>

                <div class="row margin-top-20">
                    <div class="col-xs-12">
                        {!! $component->render('include.orders', [ 'ro' => true ]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        {!! $component->render('include.customer-note', [ 'ro' => true ]) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close', false) }}</button>
            @if ($component->getModel()->userCan('write'))
                <a href="{{ $component->getModel()->getControllerRoute('show') }}" class="btn btn-primary pull-right"><i class="fa fa-pencil margin-right-10"></i>{{ $component->translate('button.edit', false) }}</a>
            @endif
            </div>
        </div>
    </div>
</div>