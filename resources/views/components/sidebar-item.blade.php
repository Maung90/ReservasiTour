@props(['icon' => 'ti ti-home', 'url' => '#'])

<li class="sidebar-item {{ request()->is($url) ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ $url }}" aria-expanded="false">
        <span>
            <i class="{{ $icon }}"></i>
        </span>
        <span class="hide-menu">{{ $slot }}</span>
    </a>
</li>
