<div class="page-main-header">
    <div class="main-header-left">
        <div class="logo-wrapper">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('') }}assets/images/logo-light-kampusbaca.png" class="image-dark" alt="" />
                <img src="{{ asset('') }}assets/images/logo-light-dark-layout-kampusbaca.png" class="image-light"
                    alt="" />
            </a>
        </div>
    </div>
    <div class="main-header-right row">
        <div class="mobile-sidebar col-1 ps-0">
            <div class="text-start switch-sm">
                <label class="switch">
                    <input type="checkbox" id="sidebar-toggle" checked>
                    <span class="switch-state"></span>
                </label>
            </div>
        </div>
        <div class="nav-right col">
            <ul class="nav-menus">
                <li class="onhover-dropdown">
                    <a href="#!" class="txt-dark">
                        <img class="align-self-center pull-right me-2"
                            src="{{ asset('') }}assets/images/dashboard/notification.png" alt="header-notification">
                        <span class="badge rounded-pill badge-primary notification">3</span>
                    </a>
                    <ul class="notification-dropdown onhover-show-div">
                        <li>
                            Notification
                            <span class="badge rounded-pill badge-secondary text-white text-uppercase pull-right">3
                                New
                            </span>
                        </li>
                        <li>
                            <div class="d-flex">
                                <i
                                    class="flex-shrink-0 align-self-center notification-icon icofont icofont-shopping-cart bg-primary"></i>
                                <div>
                                    <h6 class="mt-0">Your order ready for Ship..!</h6>
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                    <span>
                                        <i class="icofont icofont-clock-time p-r-5"></i>
                                        Just Now
                                    </span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex">
                                <i
                                    class="flex-shrink-0 align-self-center notification-icon icofont icofont-download-alt bg-success"></i>
                                <div>
                                    <h6 class="mt-0 txt-success">Download Complete</h6>
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                    <span>
                                        <i class="icofont icofont-clock-time p-r-5"></i>
                                        5 minutes ago
                                    </span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex">
                                <i
                                    class="flex-shrink-0 align-self-center notification-icon icofont icofont-recycle bg-danger"></i>
                                <div>
                                    <h6 class="mt-0 txt-danger">250 MB trush files</h6>
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                    <span>
                                        <i class="icofont icofont-clock-time p-r-5"></i>
                                        25 minutes ago
                                    </span>
                                </div>
                            </div>
                        </li>
                        <li class="text-center">
                            You have Check
                            <a href="#">all</a>
                            notification
                        </li>
                    </ul>
                </li>
                <li class="onhover-dropdown">
                    <div class="d-flex align-items-center">
                        <img class="align-self-center pull-right flex-shrink-0 me-2"
                            src="{{ asset('') }}assets/images/dashboard/user.png" alt="header-user" />
                        <div>
                            <h6 class="m-0 txt-dark f-16">
                                {{ Auth::user()->name }}
                                <i class="fa fa-angle-down pull-right ms-2"></i>
                            </h6>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div p-20">
                        <li>
                            <a href="#">
                                <i class="icon-user"></i>
                                Edit Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="icon-power-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="d-lg-none mobile-toggle">
                <i class="icon-more"></i>
            </div>
        </div>
    </div>
</div>
