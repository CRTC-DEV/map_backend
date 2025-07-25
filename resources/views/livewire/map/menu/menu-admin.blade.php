{{-- Map Group --}}
<div>
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('map') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseMap" aria-expanded="true" aria-controls="collapseMap">
            <i class="fas fa-fw fa-map"></i>
            <span>Map</span>
        </a>
        <div wire:ignore id="collapseMap" class="collapse {{ menuCollapseState('map') }}" aria-labelledby="headingMap">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Map:</h6>
                <a class="collapse-item" href="{{ route('map-item') }}">Map Item</a>
                <a class="collapse-item" href="{{ route('route-map-item') }}">Route Map Item</a>
                <a class="collapse-item" href="{{ route('route-map-item-detail') }}">Route Map Item Detail</a>
                <a class="collapse-item" href="{{ route('signage-mapitem') }}">Signage MapItem</a>
            </div>
        </div>
    </li>

    {{-- Components Group --}}
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
                <a class="collapse-item" href="{{ route('text-content') }}">Text Content</a>
                <a class="collapse-item" href="{{ route('languages') }}">Languages</a>
                <a class="collapse-item" href="{{ route('t2-location') }}">T2 Location</a>
                <a class="collapse-item" href="{{ route('translations') }}">Translations</a>
            </div>
        </div>
    </li>

    {{-- Item Group --}}
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
                <div><a class="collapse-item" href="{{ route('item-type') }}">Item Type</a></div>
                <a class="collapse-item" href="{{ route('item-title') }}">Item Title</a>
                <a class="collapse-item" href="{{ route('item-description') }}">Item Description</a>
            </div>
        </div>
    </li>

    {{-- Search Group --}}
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
                <a class="collapse-item" href="{{ route('group-search') }}">Group Search</a>
                <a class="collapse-item" href="{{ route('group-search-map-item') }}">Group Search Map Item</a>
            </div>
        </div>
    </li>

     {{-- Banner Adv && Device Touch --}}
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('banner') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseBanner" aria-expanded="true" aria-controls="collapseBanner">
            <i class="fas fa-fw fa-book"></i>
            <span>Banner Adv & Device Touch</span>
        </a>
        <div wire:ignore id="collapseBanner" class="collapse {{ menuCollapseState('banner') }}"
            aria-labelledby="headingBanner">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Search:</h6>
                <a class="collapse-item" href="{{ route('banner-adv') }}">Banner Advertisment</a>
                <a class="collapse-item" href="{{ route('banner-adv-device-touch') }}">Banner & Device Touch</a> 
            </div>
        </div>
    </li>

    {{-- Signage --}}
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
                <a class="collapse-item" href="{{ route('signage') }}">Signage</a>
                <h6 class="collapse-header">Signage & Device Touch</h6>
                <a class="collapse-item" href="{{ route('signage-devicetouch') }}">Signage DeviceTouch</a>
                <a class="collapse-item" href="{{ route('device-touch-screen') }}">Device Touch</a>
            </div>
        </div>
    </li>

    {{-- Event & Faq --}}
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('event') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseEvent" aria-expanded="true" aria-controls="collapseEvent">
            <i class="fas fa-fw fa-book"></i>
            <span>Event & Faq</span>
        </a>
        <div wire:ignore id="collapseEvent" class="collapse {{ menuCollapseState('event') }}"
            aria-labelledby="collapseEvent">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Event:</h6>
                <a class="collapse-item" href="{{ route('event') }}">Event</a>
                <h6 class="collapse-header">Faq & Faq Type:</h6>
                <a class="collapse-item" href="{{ route('faq') }}">Faq</a>
                <a class="collapse-item" href="{{ route('faq-type') }}">Faq Type</a>
                <h6 class="collapse-header">Contact & Contact Type:</h6>
                <a class="collapse-item" href="{{ route('contact-number') }}">Contact Number</a>
                <a class="collapse-item" href="{{ route('contact-number-type') }}">Contact Number Type</a>
            </div>
        </div>
    </li>

    {{-- groupfunction --}}
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('groupfunction') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseGroupFunction" aria-expanded="true" aria-controls="collapseGroupFunction">
            <i class="fas fa-fw fa-book"></i>
            <span>Group Function</span>
        </a>
        <div wire:ignore id="collapseGroupFunction" class="collapse {{ menuCollapseState('groupfunction') }}"
            aria-labelledby="headingGroupFunction" style="text:wrap">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> Function && Group:</h6>
                <a class="collapse-item" href="{{ route('groupfunction') }}">Group Function</a>
                <a class="collapse-item" href="{{ route('mainfunction') }}">Sub Function</a>                
                <a class="collapse-item" href="{{ route('group-mainfunction') }}">Group Sub Function</a>

                <h6 class="collapse-header">GroupFunction & Device</h6>
                <a class="collapse-item" href="{{ route('groupfunction-devicetouch') }}">GroupFunction Device</a>
            </div>
        </div>
    </li>

    {{-- User Group --}}
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('user') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseUser" aria-expanded="true" aria-controls="collapseUser">
            <i class="fas fa-fw fa-user"></i>
            <span>User Managerment</span>
        </a>
        <div wire:ignore id="collapseUser" class="collapse {{ menuCollapseState('user') }}"
            aria-labelledby="headingSearch">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Managerment:</h6>
                <a class="collapse-item" href="{{route('admin-management')}}">User Managerment</a>
            </div>
        </div>
    </li>
</div>
