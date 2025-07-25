<div class="{{ $isCollapsed ? 'toggled' : '' }}" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    {{-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTtYhTOo8RKwTyZAdalKXh6r00XtSVmeRpvXQ&s" alt="Logo" style="width: 36px;">
        </div>
        <div class="sidebar-brand-text mx-3">
            Map Admin <sup>1</sup>
        </div>
    </a> --}}

    <!-- Divider -->
    {{-- <hr class="sidebar-divider my-0"> --}}

    {{-- <!-- Dashboard -->
    @if(count($menuItems) > 0 && isset($menuItems[0]) && $menuItems[0]['route'] === 'dashboard')
    <li class="nav-item {{ $menuItems[0]['active'] ? 'active' : '' }}">
        <a class="nav-link" href="{{ route($menuItems[0]['route']) }}">
            <i class="{{ $menuItems[0]['icon'] }}"></i>
            <span>{{ $menuItems[0]['title'] }}</span>
        </a>
    </li>
    @endif --}}

    <!-- Divider -->
    {{-- <hr class="sidebar-divider"> --}}

    <!-- Group Menu Items by Section -->
    @php
        // Map routes by module
        $mapItems = array_filter($menuItems, function($item) {
            return in_array($item['route'], ['map-item', 'route-map-item', 'route-map-item-detail', 'signage-mapitem']);
        });
        
        $componentItems = array_filter($menuItems, function($item) {
            return in_array($item['route'], ['text-content', 'languages', 't2-location', 'translations']);
        });
        
        $itemItems = array_filter($menuItems, function($item) {
            return in_array($item['route'], ['item-type', 'item-title', 'item-description']);
        });
        
        $searchItems = array_filter($menuItems, function($item) {
            return in_array($item['route'], ['group-search', 'group-search-map-item', 'key-search']);
        });
        
        $bannerItems = array_filter($menuItems, function($item) {
            return in_array($item['route'], ['banner-adv', 'banner-adv-device-touch']);
        });
        
        $signageItems = array_filter($menuItems, function($item) {
            return in_array($item['route'], ['signage', 'signage-devicetouch', 'device-touch-screen']);
        });
        
        $eventFaqItems = array_filter($menuItems, function($item) {
            return in_array($item['route'], ['event', 'faq', 'faq-type', 'contact-number', 'contact-number-type']);
        });
        
        $groupFunctionItems = array_filter($menuItems, function($item) {
            return in_array($item['route'], ['groupfunction', 'mainfunction', 'group-mainfunction', 'groupfunction-devicetouch']);
        });
        
        $adminItems = array_filter($menuItems, function($item) {
            return in_array($item['route'], ['admin-management']);
        });
    @endphp

    <!-- Map Group -->
    @if(count($mapItems) > 0)
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('map') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseMap" aria-expanded="true" aria-controls="collapseMap">
            <i class="fas fa-fw fa-map"></i>
            <span>Map</span>
        </a>
        <div wire:ignore id="collapseMap" class="collapse {{ menuCollapseState('map') }}" aria-labelledby="headingMap">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Map:</h6>
                @foreach($mapItems as $item)
                <a class="collapse-item" href="{{ route($item['route']) }}">{{ $item['title'] }}</a>
                @endforeach
            </div>
        </div>
    </li>
    @endif

    <!-- Components Group -->
    @if(count($componentItems) > 0)
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('components') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseComponents" aria-expanded="true"
            aria-controls="collapseComponents">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div wire:ignore id="collapseComponents" class="collapse {{ menuCollapseState('components') }}"
            aria-labelledby="headingComponents">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Base Data:</h6>
                @foreach($componentItems as $item)
                <a class="collapse-item" href="{{ route($item['route']) }}">{{ $item['title'] }}</a>
                @endforeach
            </div>
        </div>
    </li>
    @endif

    <!-- Item Group -->
    @if(count($itemItems) > 0)
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('item') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseItem" aria-expanded="true" aria-controls="collapseItem">
            <i class="fas fa-fw fa-box"></i>
            <span>Item</span>
        </a>
        <div wire:ignore id="collapseItem" class="collapse {{ menuCollapseState('item') }}"
            aria-labelledby="headingItem">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Item:</h6>
                @foreach($itemItems as $item)
                <a class="collapse-item" href="{{ route($item['route']) }}">{{ $item['title'] }}</a>
                @endforeach
            </div>
        </div>
    </li>
    @endif

    <!-- Search Group -->
    @if(count($searchItems) > 0)
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('search') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseSearch" aria-expanded="true" aria-controls="collapseSearch">
            <i class="fas fa-fw fa-search"></i>
            <span>Search</span>
        </a>
        <div wire:ignore id="collapseSearch" class="collapse {{ menuCollapseState('search') }}"
            aria-labelledby="headingSearch">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Search:</h6>
                @foreach($searchItems as $item)
                <a class="collapse-item" href="{{ route($item['route']) }}">{{ $item['title'] }}</a>
                @endforeach
            </div>
        </div>
    </li>
    @endif

    <!-- Banner Adv && Device Touch -->
    @if(count($bannerItems) > 0)
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('banner') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseBanner" aria-expanded="true" aria-controls="collapseBanner">
            <i class="fas fa-fw fa-book"></i>
            <span>Banner Adv & Device Touch</span>
        </a>
        <div wire:ignore id="collapseBanner" class="collapse {{ menuCollapseState('banner') }}"
            aria-labelledby="headingBanner">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Banner:</h6>
                @foreach($bannerItems as $item)
                <a class="collapse-item" href="{{ route($item['route']) }}">{{ $item['title'] }}</a>
                @endforeach
            </div>
        </div>
    </li>
    @endif

    <!-- Signage -->
    @if(count($signageItems) > 0)
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('signage') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseSignage" aria-expanded="true" aria-controls="collapseSignage">
            <i class="fas fa-fw fa-book"></i>
            <span>Signage</span>
        </a>
        <div wire:ignore id="collapseSignage" class="collapse {{ menuCollapseState('signage') }}"
            aria-labelledby="headingSignage">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Signage:</h6>
                @foreach($signageItems as $item)
                <a class="collapse-item" href="{{ route($item['route']) }}">{{ $item['title'] }}</a>
                @endforeach
            </div>
        </div>
    </li>
    @endif

    <!-- Event & Faq -->
    @if(count($eventFaqItems) > 0)
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('event') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseEvent" aria-expanded="true" aria-controls="collapseEvent">
            <i class="fas fa-fw fa-book"></i>
            <span>Event & Faq</span>
        </a>
        <div wire:ignore id="collapseEvent" class="collapse {{ menuCollapseState('event') }}"
            aria-labelledby="collapseEvent">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Event & Faq:</h6>
                @foreach($eventFaqItems as $item)
                <a class="collapse-item" href="{{ route($item['route']) }}">{{ $item['title'] }}</a>
                @endforeach
            </div>
        </div>
    </li>
    @endif

    <!-- Group Function -->
    @if(count($groupFunctionItems) > 0)
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('groupfunction') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseGroupFunction" aria-expanded="true" aria-controls="collapseGroupFunction">
            <i class="fas fa-fw fa-book"></i>
            <span>Group Function</span>
        </a>
        <div wire:ignore id="collapseGroupFunction" class="collapse {{ menuCollapseState('groupfunction') }}"
            aria-labelledby="headingGroupFunction" style="text:wrap">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Group Function:</h6>
                @foreach($groupFunctionItems as $item)
                <a class="collapse-item" href="{{ route($item['route']) }}">{{ $item['title'] }}</a>
                @endforeach
            </div>
        </div>
    </li>
    @endif

    <!-- User Management Group -->
    @if(count($adminItems) > 0)
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('user') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseUser" aria-expanded="true" aria-controls="collapseUser">
            <i class="fas fa-fw fa-user"></i>
            <span>User Management</span>
        </a>
        <div wire:ignore id="collapseUser" class="collapse {{ menuCollapseState('user') }}"
            aria-labelledby="headingUser">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Management:</h6>
                @foreach($adminItems as $item)
                <a class="collapse-item" href="{{ route($item['route']) }}">{{ $item['title'] }}</a>
                @endforeach
            </div>
        </div>
    </li>
    @endif

</div>
