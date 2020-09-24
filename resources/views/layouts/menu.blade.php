<li class="nav-item {{ Request::is('vlat.projects*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('vlat.projects.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>@lang('models/projects.plural')</span>
    </a>
</li>

{{--<li class="nav-item {{ Request::is('models*') ? 'active' : '' }}">--}}
{{--    <a class="nav-link" href="{{ route('models.index') }}">--}}
{{--        <i class="nav-icon icon-cursor"></i>--}}
{{--        <span>@lang('models/models.plural')</span>--}}
{{--    </a>--}}
{{--</li>--}}

{{--<li class="nav-item {{ Request::is('relations*') ? 'active' : '' }}">--}}
{{--    <a class="nav-link" href="{{ route('relations.index') }}">--}}
{{--        <i class="nav-icon icon-cursor"></i>--}}
{{--        <span>@lang('models/relations.plural')</span>--}}
{{--    </a>--}}
{{--</li>--}}

{{--<li class="nav-item {{ Request::is('menus*') ? 'active' : '' }}">--}}
{{--    <a class="nav-link" href="{{ route('menus.index') }}">--}}
{{--        <i class="nav-icon icon-cursor"></i>--}}
{{--        <span>@lang('models/menus.plural')</span>--}}
{{--    </a>--}}
{{--</li>--}}

{{--<li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">--}}
{{--    <a class="nav-link" href="{{ route('users.index') }}">--}}
{{--        <i class="nav-icon icon-cursor"></i>--}}
{{--        <span>@lang('models/users.plural')</span>--}}
{{--    </a>--}}
{{--</li>--}}

