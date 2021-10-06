{!! $component->getModel()->preferences()->firstOrCreate([
    'user_id' => $component->getModel()->getKey()
])->getModelViewerComponent()->render('related.show', [ 'attribute' => 'preferences', 'relation' => 'user' ]) !!}