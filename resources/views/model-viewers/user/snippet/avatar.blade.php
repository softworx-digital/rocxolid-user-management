<div id="{{ $component->getDomId('avatar', $param) }}">
@if ($component->getModel()->image()->exists())
    {!! $component->getModel()->image->getModelViewerComponent()->render('default', [ 'image' => $component->getModel()->image, 'size' => 'thumb-square', 'class' => 'img-circle' ]) !!}
@else
    {{ Html::image('vendor/softworx/rocXolid/images/user-placeholder.svg', $component->getModel()->name, [ 'id' => 'sidebar-profile-image', 'class' => 'img-circle' ]) }}
@endif
</div>