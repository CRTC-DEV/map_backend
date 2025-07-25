<x-frontend.layouts.base>
    @if (in_array(request()->route()->getName(), ['camranh']))
        {{ $slot }}
        <!-- Footer  -->
        @include('frontend-layouts.footer')
    @else
        
        {{-- SideNav --}}
        @include('frontend-layouts.sidenav')
        <main class="content">
            
            {{ $slot }}
            {{-- Footer --}}
            @include('frontend-layouts.footer')
        </main>
    @endif
</x-frontend.layouts.base>