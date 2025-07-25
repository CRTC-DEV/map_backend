<x-admin.layouts.base>
    @if (in_array(request()->route()->getName(), ['admin.login']))
        {{ $slot }}
        <!-- Footer  -->
        @include('admin-layouts.footer')
    @else
        {{-- Nav --}}
        @include('admin-layouts.nav')

        {{-- SideNav --}}
        @include('admin-layouts.sidenav')

        <main class="content">
            {{-- TopBar --}}
            @include('admin-layouts.topbar')

            {{ $slot }}
            {{-- Footer --}}
            @include('admin-layouts.footer')
        </main>
    @endif
</x-admin.layouts.base>