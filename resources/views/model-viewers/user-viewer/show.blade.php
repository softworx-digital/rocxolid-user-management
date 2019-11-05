<div id="{{ ViewHelper::domId($component, 'customer') }}" class="x_panel ajax-overlay">
    <div class="x_content">
        {!! $component->render('include.header-panel') !!}

        <div class="row">
            <div class="col-xl-2 col-md-4 col-xs-12 margin-top-10">
                {!! $component->render('include.image') !!}
            </div>
            <div class="col-xl-4 col-xl-offset-1 col-md-4 col-xs-12">
                {!! $component->render('include.profile-data') !!}
            </div>
            <div class="col-xl-4 col-xl-offset-1 col-md-4 col-xs-12">
                <div class="row col-xs-12">
                    {!! $component->render('include.authentication-data') !!}
                </div>
                <div class="row col-xs-12">
                    {!! $component->render('include.authorization-data') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="x_footer">
        <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back', false) }}</a>
        
    </div>
</div>