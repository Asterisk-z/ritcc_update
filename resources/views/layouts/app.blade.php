@include('layouts.header')

<body>

    <div class="main-wrapper">
        {{-- <h1 class="text-center" style="color: blue;">RITCC</h1> --}}
        @include('layouts.navbar')
        @include('layouts.sidebar')
        {{-- <h1 class="text-center" style="color: blue;">RITCC</h1> --}}
        @yield('content')

        {{-- @include('layouts.footer') --}}
    </div>
    @include('layouts.scripts')
    @yield('script')
</body>

</html>