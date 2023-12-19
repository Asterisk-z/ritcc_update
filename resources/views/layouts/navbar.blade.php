<div class="header header-one">
    <a href="javascript:void(0);" id="toggle_btn">
        <span class="toggle-bars">
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
        </span>
    </a>
    <div class="top-nav-search">
        <marquee>
            <h4 class="text-center text-uppercase" style="color:#1D326C; font-size: 24px;line-height: 30px;">Road
                Infrastructure Tax
                Credit Certificate
                (RITCC)
                Auctioning System</h4>
        </marquee>
    </div>
    {{-- --}}
    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>

    {{-- <marquee>
        <h6 class="text-center text-uppercase" style="color:#1D326C;">Road Infrastructure Tax Credit Certificate
            (RITCC)
            Auctionining System</h6>
    </marquee> --}}
    <ul class="nav nav-tabs user-menu">
        <li class="nav-item dropdown">
            <a href="javascript:void(0)" class="user-link  nav-link" data-bs-toggle="dropdown">
                <span class="user-content">
                    {{-- <span class="user-details">Admin</span> --}}
                    <span class="user-name">{{ auth()->user()->firstName.' '.auth()->user()->lastName }}</span>
                </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilemenu">
                    <div class="subscription-menu">
                        <ul>
                            <li>
                                <a class="dropdown-item" href="#">Settings</a>
                            </li>
                        </ul>
                    </div>
                    <div class="subscription-logout">
                        <ul>
                            <li class="pb-0">
                                <form action="{{ route('signOut') }}" method="POST" id="logout">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="#"
                                    onclick="document.getElementById('logout').submit()">Log Out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>

    </ul>

</div>