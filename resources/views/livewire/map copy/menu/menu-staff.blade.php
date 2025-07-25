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

    {{-- DeviceTouchScreen --}}
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('device') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseDevice" aria-expanded="true" aria-controls="collapseDevice">
            <i class="fas fa-fw fa-box"></i>
            <span>Device Touch</span>
        </a>
        <div wire:ignore id="collapseDevice" class="collapse {{ menuCollapseState('device') }}"
            aria-labelledby="headingItem">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Device Touch:</h6>
                <div>
                    <a class="collapse-item" href="{{ route('device-touch-screen') }}">DeviceTouchScreen</a>
                </div>
            </div>
        </div>
    </li>

    {{-- Banner Adv --}}
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('Banner') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseBanner" aria-expanded="true" aria-controls="collapseBanner">
            <i class="fas fa-fw fa-box"></i>
            <span>Banner Ad</span>
        </a>
        <div wire:ignore id="collapseBanner" class="collapse {{ menuCollapseState('banner') }}"
            aria-labelledby="headingItem">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Banner Adv:</h6>
                <div>
                    <a class="collapse-item" href="{{ route('banner-adv') }}">Banner Ad</a>
                </div>
                <h6 class="collapse-header">Signage & Device Touch</h6>
                <a class="collapse-item" href="{{ route('signage') }}">Signage</a>
                <a class="collapse-item" href="{{ route('signage-devicetouch') }}">Signage DeviceTouch</a>
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

    {{-- Banner Adv --}}
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('banner') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseBanner" aria-expanded="true"
            aria-controls="collapseBanner">
            <i class="fas fa-fw fa-book"></i>
            <span>Banner Advertisment</span>
        </a>
        <div wire:ignore id="collapseBanner" class="collapse {{ menuCollapseState('banner') }}"
            aria-labelledby="headingBanner">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Search:</h6>
                <a class="collapse-item" href="{{ route('banner-adv') }}">Banner Advertisment</a>
                {{-- <a class="collapse-item" href="{{ route('group-search-map-item') }}">Group Search Map Item</a> --}}
            </div>
        </div>
    </li>
</div>
