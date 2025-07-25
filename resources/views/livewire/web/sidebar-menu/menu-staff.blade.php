
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