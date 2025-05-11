<!DOCTYPE html>
<html lang="en">

{{-- Header --}}
@include('layouts.header')
{{-- End Header --}}

<body class="g-sidenav-show bg-gray-200 dark-version">
    {{-- Sidebar --}}
    @include('layouts.sidebar')
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
