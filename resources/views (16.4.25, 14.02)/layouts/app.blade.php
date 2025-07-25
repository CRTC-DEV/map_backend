<x-backend.layouts.base>
    @if (in_array(request()->route()->getName(), ['login']))
        {{ $slot }}
        <!-- Footer  -->
        @include('layouts.footer')
    @else
        {{-- Nav --}}
        @include('layouts.nav')

        {{-- SideNav --}}
        @include('layouts.sidenav')

        <main class="content">
            {{-- TopBar --}}
            @include('layouts.topbar')

            {{ $slot }}
            {{-- Footer --}}
            @include('layouts.footer')
        </main>
    @endif
</x-backend.layouts.base>