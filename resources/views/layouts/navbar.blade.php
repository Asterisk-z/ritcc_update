<div class="header header-one">

    <a href="javascript:void(0);" id="toggle_btn">
        <span class="toggle-bars">
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
        </span>
    </a>

    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>
    <ul class="nav nav-tabs user-menu">
        <li class="nav-item dropdown">
            <a href="javascript:void(0)" class="user-link  nav-link" data-bs-toggle="dropdown">
                <span class="user-content">
                    {{-- <span class="user-details">Admin</span>  --}}
                    <span class="user-name">{{ $user->FirstName.' '.$user->LastName }}</span>
                </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilemenu">
                    <div class="subscription-menu">
                        <ul>
                            {{-- <li>
                                <a class="dropdown-item" href="profile.html">Profile</a>
                            </li> --}}
                            <li>
                                <a class="dropdown-item" href="#">Settings</a>
                            </li>
                        </ul>
                    </div>
                    <div class="subscription-logout">
                        <ul>
                            <li class="pb-0">
                                <a class="dropdown-item" href="{{ route('signOut') }}">Log Out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>

    </ul>

</div>
