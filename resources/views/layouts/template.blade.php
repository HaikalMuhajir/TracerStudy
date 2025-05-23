<!DOCTYPE html>
<html lang="en">

{{-- Header --}}
@include('layouts.header')
{{-- End Header --}}

<body class="g-sidenav-show" style="background-color: #062f66;">
    {{-- <div class="min-vh-100 bg-white position-absolute w-100"></div> --}}
    {{-- Sidebar --}}
    @php
        // Role sementara untuk development
        $tempRole = 'admin';
    @endphp
    @includeIf('partials.sidebar.' . ($tempRole ?? auth()->user()->role), ['activeMenu' => $activeMenu ?? ''])
    {{-- End Sidebar --}}
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- End Navbar -->
        {{-- Main Content --}}
        <div class="container-fluid py-4">
            @yield('content')
        </div>
        {{-- End Main Content --}}
        {{-- Footer --}}
        @include('layouts.footer')
        {{-- End Footer --}}
        </div>
    </main>
    {{-- Core JS --}}
    @include('layouts.corejs')
    {{-- End Core JS --}}
</body>

</html>
