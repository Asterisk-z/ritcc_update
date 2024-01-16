@include('layouts.header')

<body>

    <div class="main-wrapper">

        {{-- <p class="text-center" style="color: blue;">Road Infrastructure Tax Credit Certificate
            Auctioning System</p> --}}
        {{-- <h1 class="text-center" style="color: blue;">RITCC</h1> --}}
        @include('layouts.navbar')
        @include('layouts.sidebar')

        @yield('content')

        {{-- @include('layouts.footer') --}}
    </div>
    @include('layouts.scripts')
    @yield('script')
</body>

</html>