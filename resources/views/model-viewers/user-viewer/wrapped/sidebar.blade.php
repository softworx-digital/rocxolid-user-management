<div id="{{ $component->getDomId('sidebar') }}" class="profile clearfix">
    <div class="profile_pic">
    @if ($component->getModel()->image()->exists())
        {{ Html::image($component->getModel()->image->getControllerRoute('get', [ 'size' => 'thumb-square' ]), $component->getModel()->name, [ 'id' => 'sidebar-profile-image', 'class' => 'img-circle profile_img' ]) }}
    @else
        {{ Html::image('vendor/softworx/rocXolid/images/user-placeholder.svg', $component->getModel()->name, [ 'id' => 'sidebar-profile-image', 'class' => 'img-circle profile_img' ]) }}
    @endif
    </div>
    <div class="profile_info">
        <span>{{ $wrapper->translate('sidebar.text.welcome') }}</span>
        <h2>{!! $component->render('snippet.name', [ 'param' => 'sidebar' ]) !!}</h2>
    </div>
</div>