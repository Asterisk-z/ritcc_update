<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="#">
                <img src="{{ asset('assets/img/FMDQLogo.png') }}" class="img-fluid logo" alt>
            </a>
            <a href="#">
                <img src="{{ asset('assets/img/FMDQLogo.png') }}" class="img-fluid logo-small" alt>
            </a>
        </div>
    </div>
    <div class="sidebar-inner slimscroll pt-5">
        <div id="sidebar-menu" class="sidebar-menu">
            <br><br>
            <ul>
                @if (auth()->user()->type ==='super')
                <li class="mb-3">
                    <a href="{{ route('iqx.dashboard') }}"><i class="fas fa-home"></i><span> Dashboard</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('profile.index') }}"><i class="fas fa-users"></i><span> Profile
                            Management</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('institution.index') }}"><i class="fas fa-building"></i><span> Institution
                            Management</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('certificate.mgt.dashboard') }}"><i class="fa-solid fa-key"></i> <span>
                            Certificate Management</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('auction.mgt.dashboard') }}"><i class="fa-solid fa-key"></i> <span> Auction
                            Management</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('auction.mgt.auctions') }}"><i class="fa-solid fa-key"></i> <span> My
                            Auction</span></a>
                </li>
                <li class="">
                    <a href="{{ route('auction.mgt.history') }}"><i class="fa-solid fa-key"></i> <span> Auction
                            History</span></a>
                </li>
                <li class="">
                    <a href="#"><i class="fa-solid fa-key"></i> <span> Auction
                            Allocation</span></a>
                </li>
                <li class="mb-3">
                    <a href="#"><i class="fa-solid fa-key"></i> <span> Trade
                            Management</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('settlement') }}"><i class="fa-solid fa-key"></i> <span> Settlement</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('iqx.logs') }}"><i class="fa fa-bullseye"></i> <span> Activity Logs</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('system.settings') }}"><i class="fa fa-bullseye"></i> <span>System
                            Settings</span></a>
                </li>





                @elseif (auth()->user()->type === 'authoriser')
                <br>
                <li class="mb-3">
                    <a href="{{ route('authoriser.profile.index') }}"><i class="fas fa-bullseye"></i><span> Profile
                            Management</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('authoriser.institution.index') }}"><i class="fas fa-bullseye"></i><span>
                            Institution Management</span></a>
                </li>

                <li class="mb-3">
                    <a href="{{ route('authoriser.auction.mgt.dashboard') }}"><i class="fa fa-bullseye"></i>
                        <span>Auction Management</span></a>
                </li>







                @elseif (auth()->user()->type === 'inputter')
                <br>
                <li class="mb-3">
                    <a href="{{ route('inputter.profile.index') }}"><i class="fa fa-bullseye"></i><span> Profile
                            Management</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('inputter.institution.index') }}"><i class="fas fa-bullseye"></i><span>
                            Institution
                            Management</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('inputter.certificate.mgt.dashboard') }}"><i class="fa-solid fa-bullseye"></i>
                        <span>
                            Certificate Management</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('inputter.auction.mgt.dashboard') }}"><i class="fa fa-bullseye"></i> <span>
                            Auction
                            Management</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('settlement') }}"><i class="fa fa-bullseye"></i> <span> Settlement</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('system.settings') }}"><i class="fa fa-bullseye"></i> <span>System
                            Settings</span></a>
                </li>

                @elseif (auth()->user()->type === 'firs')
                <br><br>
                <li class="mb-3">
                    <a href="{{ route('firs.certificate.mgt.dashboard') }}"><i class="fa-solid fa-bullseye"></i> <span>
                            Certificate Management</span></a>
                </li>

                @elseif (auth()->user()->type === 'auctioneer')
                <li class="mb-3">
                    <a href="{{ route('bank.dashboard') }}">
                        <i class="fa-solid fa-key"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('bank.mgt.auctions') }}">
                        <i class="fa-solid fa-key"></i>
                        <span>Auctions</span>
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('auction.mgt.allocation') }}"><i class="fa-solid fa-key"></i> <span> Auction
                            Allocation</span></a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('auction.mgt.results') }}"><i class="fa-solid fa-key"></i> <span> Auction
                            Results</span></a>
                </li>

                @elseif (auth()->user()->type === 'bidder' )
                <li class="mb-3">
                    <a href="{{ route('bank.dashboard') }}">
                        <i class="fa-solid fa-key"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('trade.mgt.dashboard') }}"><i class="fa-solid fa-key"></i> <span>Trade</span></a>

                </li>
                <li class="mb-3">
                    <a href="{{ route('trade.mgt.dashboard', 'result') }}"><i class="fa-solid fa-key"></i>
                        <span>Allocated Trade</span></a>

                </li>
                @endif
                <li class="mb-3">
                    <a href="{{ route('myLogs') }}"><i class="fa fa-bullseye"></i>
                        <span>My Activity Logs</span></a>

                </li>
            </ul>

        </div>
    </div>
</div>