<!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        @guest
            
            <li class="d-none d-sm-block"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            <li class="d-none d-sm-block"><a class="nav-link" href="{{ route('register') }}">Register</a></li>

        @else
        <li class="d-none d-sm-block">
            <form class="app-search">
                <div class="app-search-box">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <div class="input-group-append">
                            <button class="btn" type="submit">
                                <i class="fe-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </li>

        <li class="dropdown notification-list notif-icon">
            <a id="noticon" class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fe-bell noti-icon"></i>
                
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                                    <span class="float-right">
                                        <a href="javascript: void(0);" onclick="clearNotif()" class="text-dark">
                                            <small>Clear All</small>
                                        </a>
                                    </span>Notification
                                </h5>
                </div>

                <div class="slimscroll noti-scroll" style="height: 200px">

                </div>

                <!-- All-->
                <a href="{{ url('notifications') }}" class="dropdown-item text-center text-primary notify-item notify-all">
                                View all
                                <i class="fi-arrow-right"></i>
                            </a>

            </div>
        </li>

            <li class="dropdown notification-list">

            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{ Auth::user()->image_profile }}" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ml-1">
                    {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i> 
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome !</h6>
                </div>

                <!-- item-->
                <a href="{{ url('profile') }}/{{ Auth::user()->id }}" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>My Profile</span>
                </a>

                <!-- item-->
                <a href="{{ url('profile') }}/{{ Auth::user()->id }}/edit" class="dropdown-item notify-item">
                    <i class="fe-settings"></i>
                    <span>Settings</span>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="fe-lock"></i>
                    <span>Lock Screen</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="{{ route('logout') }}" class="dropdown-item notify-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }} </form>
                </a>

            </div>
        </li>
        <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                <i class="fe-settings noti-icon"></i>
            </a>
        </li>
        @endguest
    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="index.html" class="logo text-center">
            <span class="logo-lg">
                            <img src="asset/images/logo-light.png" alt="" height="18">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
            </span>
            <span class="logo-sm">
                            <!-- <span class="logo-sm-text-dark">U</span> -->
            <img src="asset/images/logo-sm.png" alt="" height="24">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="fe-menu"></i>
            </button>
        </li>
        <li>
            <a class="nav-link waves-effect waves-light" href="/">Home</a>
        </li>
    </ul>
</div>
<!-- end Topbar -->

@section('footer')
<script type="text/javascript">
    function clearNotif(){
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: 'http://127.0.0.1:8000/notif/cn',
            success: function (data) {
                console.log(data);
                $(".noti-icon-badge").remove();
                //$("#noticon").append('<span class="badge badge-danger rounded-circle noti-icon-badge">'+data+'</span>')
                //$(".noti-icon-badge").html(data)   //// For replace with previous one
            },
            error: function() { 
                console.log(data);
            }
        });
    }
</script>
@endsection