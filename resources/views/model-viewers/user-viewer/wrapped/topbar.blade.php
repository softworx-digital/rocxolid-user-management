<ul id="{{ $component->getDomId('topbar') }}" class="nav navbar-nav navbar-right">
    <li>
        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown">
        @if ($component->getModel()->image()->exists())
            {{ Html::image($component->getModel()->image->getControllerRoute('get', [ 'size' => 'thumb-square' ]), $component->getModel()->name, [ 'id' => 'topbar-profile-image' ]) }}
        @else
            {{ Html::image('vendor/softworx/rocXolid/images/user-placeholder.svg', $component->getModel()->name, [ 'id' => 'topbar-profile-image' ]) }}
        @endif
            {!! $component->render('snippet.name', [ 'param' => 'topbar' ]) !!}
            <span class="fa fa-angle-down margin-left-10"></span>
        </a>
        <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li>
                <a href="{{ $component->getModel()->getProfileControllerRoute() }}"><i class="fa fa-id-badge"></i> {{ $wrapper->translate('auth.profile') }}</a>
            </li>
        @if (false)
            <li>
                <a href="{{ $component->getModel()->getProfileControllerRoute('settings') }}"><i class="fa fa-cog"></i> {{ $wrapper->translate('auth.settings') }}</a>
            </li>
        @endif
            <li>
                <a href="{{ route('rocXolid.auth.logout') }}"><i class="fa fa-sign-out"></i> {{ $wrapper->translate('auth.logout') }}</a>
            </li>
        </ul>
    </li>
@if (false)
    <li role="presentation" class="dropdown">
        <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="badge bg-green">1</span>
        </a>
        <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
            <li>
                <a>
                    <span class="image">{{ Html::image('images/img.jpg', 'username') }}</span>
                    <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                    </span>
                    <span class="message">Film festivals used to be do-or-die moments for movie makers. They were where...</span>
                </a>
            </li>
            <li>
                <div class="text-center">
                    <a>
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </li>
        </ul>
    </li>
@endif
</ul>