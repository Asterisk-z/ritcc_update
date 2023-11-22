<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="{{ route('iqx.dashboard') }}">
                <img src="{{ asset('assets/img/FMDQLogo.png') }}" class="img-fluid logo" alt>
            </a>
            <a href="{{ route('iqx.dashboard') }}">
                <img src="{{ asset('assets/img/FMDQLogo.png') }}" class="img-fluid logo-small" alt>
            </a>
        </div>
    </div>
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">

            <ul>
                <li class="">
                    <a href="{{ route('iqx.dashboard') }}"><i class="fas fa-home"></i><span> Dashboard</span>
                </li>
                <li class="">
                    <a href="{{ route('profile.index') }}"><i class="fas fa-users"></i><span> Profile
                            Management</span>
                </li>
                <li class="">
                    <a href="{{ route('institution.index') }}"><i class="fas fa-building"></i><span> Institution
                            Management</span>
                </li>
                <li class="">
                    <a href="#"><i class="fa-solid fa-key"></i> <span> Certificate
                            Management</span>
                </li>
                <li class="">
                    <a href="{{ route('auction.mgt.dashboard') }}"><i class="fa-solid fa-key"></i> <span> Auction
                            Management</span>
                </li>
                <li class="">
                    <a href="#"><i class="fa-solid fa-key"></i> <span> Auction
                            Allocation</span>
                </li>
                <li class="">
                    <a href="#"><i class="fa-solid fa-key"></i> <span> Trade
                            Management</span>
                </li>
                <li class="">
                    <a href="#"><i class="fa-solid fa-key"></i> <span> Settlement</span>
                </li>

                <li class="submenu">
                    <a href="#"><i class="fa-solid fa-gear"></i></i> <span> System Settings</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="#">Packages</a></li>
                        <li><a href="#">Public Holidays</a></li>
                        <li><a href="#">Auction Window</a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</div>
