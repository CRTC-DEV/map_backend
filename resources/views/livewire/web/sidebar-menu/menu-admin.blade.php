{{-- Map Group --}}
<div>
    {{-- Component Group --}}
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
                <a class="collapse-item" href="{{ route('admin.text-content') }}">Text Content</a>
                <a class="collapse-item" href="{{ route('admin.languages') }}">Languages</a>
                <a class="collapse-item" href="{{ route('admin.translations') }}">Translations</a>
                <a class="collapse-item" href="{{ route('admin.title') }}">Title</a>
                <a class="collapse-item" href="{{ route('admin.description') }}">Description</a>

            </div>
        </div>
    </li>
    {{-- Menu Group --}}
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('sidebar-menu') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseMenu" aria-expanded="true"
            aria-controls="collapseMenu">
            <i class="fas fa-fw fa-book"></i>
            <span>Menu Group</span>
        </a>
        <div wire:ignore id="collapseMenu" class="collapse {{ menuCollapseState('sidebar-menu') }}"
            aria-labelledby="headingComponents">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Base Data:</h6>
                <a class="collapse-item" href="{{ route('admin.topmenu') }}">Top Menu</a>
                <a class="collapse-item" href="{{ route('admin.submenu') }}">Sub Menu</a>
                <a class="collapse-item" href="{{ route('admin.submenuontopmenu') }}">SubMenu On TopMenu</a>

            </div>
        </div>
    </li>
     {{-- Menu Group --}}
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('connect-business') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseConnectBusiness" aria-expanded="true"
            aria-controls="collapseConnectBusiness">
            <i class="fas fa-fw fa-book"></i>
            <span>Connect Business</span>
        </a>
        <div wire:ignore id="collapseConnectBusiness" class="collapse {{ menuCollapseState('connect-business') }}"
            aria-labelledby="headingComponents">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Base Data:</h6>
                <a class="collapse-item" href="{{ route('admin.connect.business') }}">Connect Business</a>

            </div>
        </div>
    </li>
    {{-- Admin Group --}}
    <li class="nav-item">
        <a class="nav-link {{ menuCollapseState('user') == 'show' ? '' : 'collapsed' }}" href="#"
            data-toggle="collapse" data-target="#collapseUser" aria-expanded="true" aria-controls="collapseUser">
            <i class="fas fa-fw fa-user"></i>
            <span>Amin Managerment</span>
        </a>
        <div wire:ignore id="collapseUser" class="collapse {{ menuCollapseState('user') }}"
            aria-labelledby="headingSearch">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Admin Managerment:</h6>
                <a class="collapse-item" href="{{route('admin.web')}}">Admin Managerment</a>
            </div>
        </div>
    </li>
</div>
