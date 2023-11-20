@include('layouts.header')

<body>
    <div class="main-wrapper">
        @include('layouts.navbar')
        @include('layouts.sidebar')
        @yield('content')
        {{-- @include('layouts.footer') --}}
    </div>
    @include('layouts.scripts')
    @yield('script')
</body>

</html>
